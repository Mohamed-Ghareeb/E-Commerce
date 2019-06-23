@extends('style.index')
@section('content')

  <div class="mainmenu-area">
      <div class="container">
          <div class="row">
            <br>
            <br>
            <br>
            {!! setting()->message_maintenance !!}
            <br>
            <br>
            <br>

          </div>
      </div>
  </div>
@endsection
