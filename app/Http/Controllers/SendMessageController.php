<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Mail;
use Validator;

class SendMessageController extends Controller {

  public function sendMessage(Request $request) {
    $this->doValidate($request);
    $name = $request->input("name");
    $surname = $request->input("surname");
    $message = $request->input("message");
    $photo = $request->file("photo");
    $this->sendMail($message, $photo);
    return back()
      ->with("sent", true)
      ->with("name", $name);
  }

  private function doValidate($request) {
    $validator = Validator::make($request->all(), [
        "name" => "required|max:10",
        "surname" => "required|max:10",
        "photo" => "required",
        "message" => "required|max:50",
    ], [], []);
    $niceNames = array(
      "name" => trans("messages.contact_form_name_field"),
      "surname" => trans("messages.contact_form_surname_field"),
      "photo" => trans("messages.contact_form_photo_field"),
      "message" => trans("messages.contact_form_message_field"),
    );
    $validator->setAttributeNames($niceNames);
    if ($validator->fails()) {
      $this->throwValidationException($request, $validator);
    }
  }

  private function sendMail($message, $photo) {
    Mail::send(["raw" => $message], [], function ($message) use ($photo) {
      $message
        ->to(env("CONTACT_FORM_TO_ADDRESS"))
        ->from(env("CONTACT_FORM_FROM_ADDRESS"), env("CONTACT_FORM_FROM_NAME"))
        ->sender(env("CONTACT_FORM_FROM_ADDRESS"), env("CONTACT_FORM_FROM_NAME"))
        ->replyTo(env("CONTACT_FORM_FROM_ADDRESS"), env("CONTACT_FORM_FROM_NAME"))
        ->subject(trans("messages.contact_form_subject"))
        ->attach($photo, ["as" => $photo->getClientOriginalName()]);
    });
  }
}
