@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script type="text/javascript">
Dropzone.autoDiscover = false;
  $(document).ready(function () {


    $('#dropzonefileupload').dropzone({

      url                 : "{{ aurl('upload/image/' . $product->id) }}",
      paramName           : 'file',
      autoDiscover        : false,
      uploadMultiple      : false,
      maxFiles            : 10,
      maxFilesize         : 5,
      acceptedFiles       : 'image/*',
      dictRemoveFile      : "{{ trans('admin.delete') }}",
      dictDefaultMessage  : "{{ trans('admin.message_upload') }}",
      params              : {
        _token : "{{ csrf_token() }}"
      },

      addRemoveLinks      : true,
      removedfile:function(file) {

        $.ajax({
          dataType : "json",
          type     : "post",
          data     : {_token : "{{ csrf_token() }}", id: file.fid},
          url      : "{{ aurl('delete/image') }}",

        });

        var fmock;

        return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement) : void 0;

      },
      init:function() {

          @foreach ($product->files()->get() as $file)

            var mock = {name: '{{ $file->name }}', fid: '{{ $file->id }}', size: '{{ $file->size }}', type: '{{ $file->mime_type }}'};
            this.emit('addedfile', mock);
            this.options.thumbnail.call(this, mock, "{{ url('storage/' . $file->full_file) }}");

          @endforeach

      }
    });

    $('#main_photo').dropzone({

        url                 : "{{ aurl('update/image/' . $product->id) }}",
        paramName           : 'file',
        autoDiscover        : false,
        uploadMultiple      : false,
        maxFiles            : 1,     // 1 File
        maxFilesize         : 3,    // MB
        acceptedFiles       : 'image/*',  // Every Extension For Images
        dictRemoveFile      : "{{ trans('admin.delete') }}",    // The Default Remove Link
        dictDefaultMessage  : "{{ trans('admin.message_upload') }}",  // The Default Message To Upload
        params              : {
          _token : "{{ csrf_token() }}"
        },

        addRemoveLinks      : true,
        removedfile:function(file) {                // This Function Delete The Image From [ Storage ] & Delete From Database

          $.ajax({
            dataType : "json",
            type     : "post",
            data     : {_token : "{{ csrf_token() }}"},
            url      : "{{ aurl('delete/product/image/' . $product->id) }}",

          });

          var fmock;

          return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement) : void 0;

        },
        init:function() {

          @if (!empty($product->photo))

              var mock = {name: '{{ $product->title }}', size: '', type: ''};
              this.emit('addedfile', mock);
              this.options.thumbnail.call(this, mock, "{{ url('storage/' . $product->photo) }}");
              $('.dz-progress').remove();
          @endif


        }
        });


  });
</script>

<style media="screen">
  .dz-image img {
    width: 120px;
    height: 120px;
  }
</style>

@endpush


<div id="product_media" class="tab-pane fade">
  <h3>{{ trans('admin.product_media') }}</h3>
  <hr>
<h3 class="text-center">{{ trans('admin.main_photo') }}</h3>
<div class="dropzone" id="main_photo"></div>
<h3 class="text-center">{{ trans('admin.photos') }}</h3>
<div class="dropzone" id="dropzonefileupload"></div>
</div>
