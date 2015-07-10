@extends("parent")

@section("title", trans("messages.contact_form_title"))

@section("content")
   <form action="send_message" method="POST" enctype="multipart/form-data">
    <header>
      <h1>{{trans("messages.contact_form_title")}}</h1>
    </header>
    @foreach (["name", "surname", "photo", "message"] as $field)
      <div>
        <label for="{{$field}}">{{trans("messages.contact_form_" . $field . "_field")}}</label>
        <div>
          @if ($field === "photo")
            <input name="{{$field}}" type="file" accept="image/*"><br>
          @elseif ($field === "message")
            <textarea name="{{$field}}"></textarea>
          @else
            <input name="{{$field}}" type="text">
          @endif
          @if ($errors->has($field))
            <div class="error">
              <span class="error">{{$errors->first($field)}}<span>
            </div>
          @endif
        </div>
      </div>
    @endforeach
    <div>
      <div id="button">
        <button>{{trans("messages.contact_form_send_button")}}</button>
      </div>
    </div>
    @if (session("sent"))
      <p>
        <span class="success">{{trans("messages.send_message_sent_message", ["name" => session("name")])}}</span>
      </p>
    @endif
    {{csrf_field()}}
  </form>
@endsection
