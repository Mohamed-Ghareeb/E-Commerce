@push('js')
<script type="text/javascript">
  $('.datepicker').datepicker({
    rtl       : {{ session('lang') == 'ar' ? true : false }},
    language  : "{{ session('lang') }}",
    format    : "yyyy-mm-dd",
    autoclose : false,
    todayBtn  : true,
    clearBtn  : true,
  });


$(document).on('change', '.status', function () {

  var status = $('.status option:selected').val();

  if (status == 'refused') {
      $('.reason').removeClass('hidden');
  } else {
      $('.reason').addClass('hidden');
  }

});



</script>
@endpush


<div id="product_setting" class="tab-pane fade">
  <h3>{{ trans('admin.product_setting') }}</h3>
  <hr>

  <div class="form-group col-md-3 col-lg-3 col-sm-6 col-xs-12">
    {!! Form::label('stock', trans('admin.product_stock')) !!}
    {!! Form::text('stock', $product->stock, ['class' => 'form-control', 'placeholder' => trans('admin.product_stock')]) !!}
  </div>
  <div class="form-group col-md-3 col-lg-3 col-sm-6 col-xs-12">
    {!! Form::label('price', trans('admin.product_price')) !!}
    {!! Form::text('price', $product->price, ['class' => 'form-control', 'placeholder' => trans('admin.product_price')]) !!}
  </div>
  <div class="form-group col-md-3 col-lg-3 col-sm-6 col-xs-12">
    {!! Form::label('start_at', trans('admin.product_start_at')) !!}
    {!! Form::text('start_at', $product->start_at, ['class' => 'form-control datepicker', 'placeholder' => trans('admin.product_start_at')]) !!}
  </div>
  <div class="form-group col-md-3 col-lg-3 col-sm-6 col-xs-12">
    {!! Form::label('end_at', trans('admin.product_end_at')) !!}
    {!! Form::text('end_at', $product->end_at, ['class' => 'form-control datepicker', 'placeholder' => trans('admin.product_end_at')]) !!}
  </div>

  <div class="clearfix"></div>

  <div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
    {!! Form::label('price_offer', trans('admin.product_price_offer')) !!}
    {!! Form::text('price_offer', $product->price_offer, ['class' => 'form-control', 'placeholder' => trans('admin.product_price_offer')]) !!}
  </div>
  <div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
    {!! Form::label('start_offer_at', trans('admin.product_start_offer_at')) !!}
    {!! Form::text('start_offer_at', $product->start_offer_at, ['class' => 'form-control datepicker', 'placeholder' => trans('admin.product_start_offer_at')]) !!}
  </div>
  <div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
    {!! Form::label('end_offer_at', trans('admin.product_end_offer_at')) !!}
    {!! Form::text('end_offer_at', $product->end_offer_at, ['class' => 'form-control datepicker', 'placeholder' => trans('admin.product_end_offer_at')]) !!}
  </div>

  <div class="clearfix"></div>

  <div class="form-group">
    {!! Form::label('status', trans('admin.product_status')) !!}
    {!! Form::select('status', ['pending' => trans('admin.pending'), 'refused' => trans('admin.refused'), 'active' => trans('admin.active')], $product->status, ['class' => 'form-control status']) !!}
  </div>
  <div class="form-group reason {{ $product->reason != 'refused' ? 'hidden' : '' }}">
    {!! Form::label('reaso', trans('admin.product_reason')) !!}
    {!! Form::textarea('reaso', $product->reason, ['class' => 'form-control', 'placeholder' => trans('admin.product_reason')]) !!}
  </div>



</div>
