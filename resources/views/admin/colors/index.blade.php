@extends('admin.index')
@section('content')

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      {!! Form::open(['id' => 'form_data', 'url' => aurl('colors/destroy/all'), 'method' => 'delete']) !!}
      {!! $dataTable->table(['class'   => 'dataTable table table-striped table-hover'], true) !!}
      {!! Form::close() !!}

    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->


  <!-- The Modal -->
  <div class="modal modal fade" id="multipleDelete">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{ trans('admin.delete') }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="alert alert-danger">
              <div class="empty_record hidden">
                <h3>{{ trans('admin.the_message_for_delete') }}</h3>
              </div>
              <div class="not_empty_record hidden">
                <h3>{{ trans('admin.ask_delete_item') }}  <span class="record_count"> {{ trans('admin.record') }} </span> @if(direction() == 'rtl') ؟ @else ? @endif</h3>
              </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <div class="empty_record hidden">
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('admin.close') }}</button>
          </div>
          <div class="not_empty_record hidden">
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('admin.no') }}</button>
            <input type="submit" name="del_all" class="btn btn-primary del_all" value="{{ trans('admin.yes') }}" />
        </div>
        </div>

      </div>
    </div>
  </div>



@push('js')

<script>
  delete_all();
  check_all();
</script>

  {!! $dataTable->scripts() !!}

@endpush


@endsection
