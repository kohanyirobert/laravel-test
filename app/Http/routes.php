<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(["middleware" => "locale"], function () {
  Route::get("/", function () {
    return view("contact_form");
  });

  Route::post("/send_message", "SendMessageController@sendMessage");
});
