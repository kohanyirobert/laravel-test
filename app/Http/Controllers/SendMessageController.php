<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Mail;

class SendMessageController extends Controller {

  public function sendMessage(Request $request) {
    $this->validate($request, [
        "name" => "required|max:10",
        "surname" => "required|max:10",
        "photo" => "required",
        "message" => "required|max:50",
    ]);
    $name = $request->input("name");
    $surname = $request->input("surname");
    $message = $request->input("message");
    $photo = $request->file("photo");
    Mail::send(["raw" => $message], [], function ($message) use ($photo) {
      $message
        ->to(env("CONTACT_FORM_TO_ADDRESS"))
        ->from(env("CONTACT_FORM_FROM_ADDRESS"), env("CONTACT_FORM_FROM_NAME"))
        ->sender(env("CONTACT_FORM_FROM_ADDRESS"), env("CONTACT_FORM_FROM_NAME"))
        ->replyTo(env("CONTACT_FORM_FROM_ADDRESS"), env("CONTACT_FORM_FROM_NAME"))
        ->subject(trans("messages.contact_form_subject"))
        ->attach($photo, ["as" => $photo->getClientOriginalName()]);
    });
    return back()
      ->with("sent", true)
      ->with("name", $name);
  }
}
