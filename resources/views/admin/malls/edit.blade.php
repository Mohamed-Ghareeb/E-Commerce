@extends('admin.index')
@section('content')
  @push('js')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyAqQZukuqiPG12VkNYG0JWLf6jXa8bqPfU'></script>
    <script type="text/javascript" src="{{ url('design/adminlte/dist/js/locationpicker.jquery.js') }}"></script>

    <?php

      $lat = !empty($mall->lat) ? $mall->lat : 30.056220559585114;
      $lng = !empty($mall->lng) ? $mall->lng : 31.26604154745246;

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
          },
            enableAutocomplete: true
      });
    </script>

  @endpush
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      {!! Form::open(['route' => ['malls.update', $mall->id], 'method' => 'put', 'files' => true]) !!}

      <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
      <input type="hidden" name="lng" id="lng" value="{{ $lng }}">

      <div class="form-group">
        {!! Form::label('name_en', trans('admin.name_en')) !!}
        {!! Form::text('name_en', $mall->name_en, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('name_ar', trans('admin.name_ar')) !!}
        {!! Form::text('name_ar', $mall->name_ar, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('mobile', trans('admin.mobile')) !!}
        {!! Form::text('mobile', $mall->mobile, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('contact_name', trans('admin.contact_name_mall')) !!}
        {!! Form::text('contact_name', $mall->contact_name, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('email', trans('admin.email')) !!}
        {!! Form::email('email', $mall->email, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('country_id', trans('admin.country_id')) !!}
        {!! Form::select('country_id', App\Model\Country::pluck('country_name_' . session('lang'), 'id'), old('country_id'), ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('address', trans('admin.address')) !!}
        {!! Form::text('address', $mall->address, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">

        <div id="us1" style="width: 80%; height: 400px;"></div>

      </div>

      <div class="form-group">
        {!! Form::label('facebook', trans('admin.facebook')) !!}
        {!! Form::text('facebook', $mall->facebook, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('twitter', trans('admin.twitter')) !!}
        {!! Form::text('twitter', $mall->twitter, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('website', trans('admin.website')) !!}
        {!! Form::text('website', $mall->website, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('icon', trans('admin.icon')) !!}
        {!! Form::file('icon', ['class' => 'form-control']) !!}
          @if (!empty($mall->icon))
            <img src="{{ Storage::url($mall->icon) }}" style="width:100px;height:80px">
          @endif
      </div>


        {!! Form::submit(trans('admin.save'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection
