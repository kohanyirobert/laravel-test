@extends("parent")

@section("title", trans("messages.contact_form_title"))

@section("content")
  @if (session("sent"))
    <div id="message_box">
      <p>{{trans("messages.send_message_sent_message", ["name" => session("name")])}}</p>
    </div>
  @endif
  @if (count($errors) > 0)
    <div id="error_box">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form id="contact_form" action="send_message" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    <label for="name">{{trans("messages.contact_form_name_field")}}</label>
    <input name="name"><br>
    <label for="surname">{{trans("messages.contact_form_surname_field")}}</label>
    <input name="surname"><br>
    <label for="photo">{{trans("messages.contact_form_photo_field")}}</label>
    <input name="photo" type="file" accept="image/*"><br>
    <label for="message">{{trans("messages.contact_form_message_field")}}</label>
    <input name="message"><br>
    <button type="submit">{{trans("messages.contact_form_send_button")}}</button>
  </form>
@endsection
