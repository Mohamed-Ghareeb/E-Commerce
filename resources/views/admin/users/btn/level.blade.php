
<span class="label
  {{ $level == 'user' ? 'label-info' :'' }}
  {{ $level == 'vendor' ? 'label-primary' :'' }}
  {{ $level == 'company' ? 'label-warning' :'' }}
">

  {{ trans('admin.' . $level) }}
</span>
