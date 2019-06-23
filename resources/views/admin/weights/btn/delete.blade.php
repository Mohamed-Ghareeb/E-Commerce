<!-- Button to Open the Modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_admin{{ $id }}">
  <i class="fa fa-trash"></i>
</button>

<!-- The Modal -->
<div class="modal" id="del_admin{{ $id }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ trans('admin.delete') }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3>{{ trans('admin.delete_this', ['name' =>  session('lang') == 'ar' ? $name_ar : $name_en ]) }}<span>@if(direction() == 'rtl') ؟ @else ? @endif</span></h3>
      </div>

      {!! Form::open(['route' => ['weights.destroy', $id], 'method' => 'delete']) !!}

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">{{ trans('admin.close') }}</button>
        {!! Form::submit(trans('admin.yes'), ['class' => 'btn btn-danger']) !!}
      </div>

      {!! Form::close() !!}

    </div>
  </div>
</div>
