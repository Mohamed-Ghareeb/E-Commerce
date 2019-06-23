@extends('admin.index')
@section('content')
@push('js')
  <script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyAqQZukuqiPG12VkNYG0JWLf6jXa8bqPfU'></script>
  <script type="text/javascript" src="{{ url('design/adminlte/dist/js/locationpicker.jquery.js') }}"></script>

  <?php

    $lat = !empty(old('lat')) ? old('lat') : 30.056220559585114;
    $lng = !empty(old('lng')) ? old('lng') : 31.26604154745246;

  ?>

  <script>
    $('#us1').locationpicker({
        location: {
            latitude: {{ $lat }},
            longitude: {{ $lng }}
        },
        radius: 300,
        inputBinding: {
            latitudeInput: $('#lat'),
            longitudeInput: $('#lng'),
            // radiusInput: $('#us2-radius'),
            // locationNameInput: $('#address')
        }
    });
  </script>

@endpush


  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['route' => 'shippings.store', 'files' => true]) !!}

        <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
        <input type="hidden" name="lng" id="lng" value="{{ $lng }}">

        <div class="form-group">
          {!! Form::label('name_en', trans('admin.name_en')) !!}
          {!! Form::text('name_en', old('name_en'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('name_ar', trans('admin.name_ar')) !!}
          {!! Form::text('name_ar', old('name_ar'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('user_id', trans('admin.user_id')) !!}
          {!! Form::select('user_id', App\User::where('level', 'company')->pluck('name', 'id'), old('user_id'), ['class' => 'form-control', 'placeholder' => '.......']) !!}
        </div>
        <div class="form-group">

          <div id="us1" style="width: 80%; height: 400px;"></div>

        </div>
        <div class="form-group">
          {!! Form::label('icon', trans('admin.icon')) !!}
          {!! Form::file('icon', ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit(trans('admin.create_shippings'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection
