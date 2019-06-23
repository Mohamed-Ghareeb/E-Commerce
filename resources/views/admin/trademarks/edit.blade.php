@extends('admin.index')
@section('content')

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      {!! Form::open(['route' => ['trademarks.update', $trade->id], 'method' => 'put', 'files' => true]) !!}

        <div class="form-group">
          {!! Form::label('name_en', trans('admin.name_en')) !!}
          {!! Form::text('name_en', $trade->name_en, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('name_ar', trans('admin.name_ar')) !!}
          {!! Form::text('name_ar', $trade->name_ar, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('logo', trans('admin.country_flag')) !!}
          {!! Form::file('logo', ['class' => 'form-control']) !!}
          @if (!empty($trade->logo))
            <img src="{{ Storage::url($trade->logo) }}" style="width:100px;height:80px">
          @endif
        </div>

        {!! Form::submit(trans('admin.save'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection
