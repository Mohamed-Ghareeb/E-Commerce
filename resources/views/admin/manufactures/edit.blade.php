@extends('admin.index')
@section('content')
  @push('js')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyAqQZukuqiPG12VkNYG0JWLf6jXa8bqPfU'></script>
    <script type="text/javascript" src="{{ url('design/adminlte/dist/js/locationpicker.jquery.js') }}"></script>

    <?php

      $lat = !empty($manufacture->lat) ? $manufacture->lat : 30.056220559585114;
      $lng = !empty($manufacture->lng) ? $manufacture->lng : 31.26604154745246;

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
              locationNameInput: $('#address')
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
      {!! Form::open(['route' => ['manufactures.update', $manufacture->id], 'method' => 'put', 'files' => true]) !!}

      <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
      <input type="hidden" name="lng" id="lng" value="{{ $lng }}">

      <div class="form-group">
        {!! Form::label('man_name_en', trans('admin.name_en')) !!}
        {!! Form::text('man_name_en', $manufacture->man_name_en, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('man_name_ar', trans('admin.name_ar')) !!}
        {!! Form::text('man_name_ar', $manufacture->man_name_ar, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('mobile', trans('admin.mobile')) !!}
        {!! Form::text('mobile', $manufacture->mobile, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('contact_name', trans('admin.contact_name')) !!}
        {!! Form::text('contact_name', $manufacture->contact_name, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('email', trans('admin.email')) !!}
        {!! Form::email('email', $manufacture->email, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('address', trans('admin.address')) !!}
        {!! Form::text('address', $manufacture->address, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">

        <div id="us1" style="width: 80%; height: 400px;"></div>

      </div>

      <div class="form-group">
        {!! Form::label('facebook', trans('admin.facebook')) !!}
        {!! Form::text('facebook', $manufacture->facebook, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('twitter', trans('admin.twitter')) !!}
        {!! Form::text('twitter', $manufacture->twitter, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('website', trans('admin.website')) !!}
        {!! Form::text('website', $manufacture->website, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('icon', trans('admin.icon')) !!}
        {!! Form::file('icon', ['class' => 'form-control']) !!}
          @if (!empty($manufacture->icon))
            <img src="{{ Storage::url($manufacture->icon) }}" style="width:100px;height:80px">
          @endif
      </div>


        {!! Form::submit(trans('admin.save'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection
