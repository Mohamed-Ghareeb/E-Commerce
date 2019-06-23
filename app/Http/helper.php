<?php

if(!function_exists('setting')) {

    function setting() {
      return \App\Model\Setting::orderBy('id', 'desc')->first();
    }
}


if(!function_exists('aurl')) {        // aurl  !! mean =====>>> Admin Url

    function aurl($url = null) {
      return url('admin/' . $url);
    }
}
if(!function_exists('languages')) {

  function languages() {

      $langJson = [

          'sProcessing'       => trans('admin.sProcessing'),
          'sLengthMenu'       => trans('admin.sLengthMenu'),
          'sZeroRecords'      => trans('admin.sZeroRecords'),
          'sEmptyTable'       => trans('admin.sEmptyTable'),
          'sInfo'             => trans('admin.sInfo'),
          'sInfoEmpty'        => trans('admin.sInfoEmpty'),
          'sInfoFiltered'     => trans('admin.sInfoFiltered'),
          'sInfoPostFix'      => trans('admin.sInfoPostFix'),
          'sSearch'           => trans('admin.sSearch'),
          'sUrl'              => trans('admin.sUrl'),
          'sInfoThousands'    => trans('admin.sInfoThousands'),
          'sLoadingRecords'   => trans('admin.sLoadingRecords'),
          'sLoadingRecords'   => trans('admin.sLoadingRecords'),
          'oPaginate'         => [

              'sFirst'     => trans('admin.sFirst'),
              'sLast'      => trans('admin.sLast'),
              'sNext'      => trans('admin.sNext'),
              'sPrevious'  => trans('admin.sPrevious'),
          ],

          'oAria'              => [

              'sSortAscending'  => trans('admin.sSortAscending'),
              'sSortDescending'  => trans('admin.sSortDescending'),
          ],

      ];

      return $langJson;
  }

}
if(!function_exists('admin')) {

    function admin() {
      return auth()->guard('admin');
    }
}

if(!function_exists('lang')) {

    function lang() {
      if (session()->has('lang')) {
          return session('lang');
      } else {
        session()->put('lang', setting()->main_lang);
          return setting()->main_lang;
      }
    }
}

if(!function_exists('active_menu')) {

    function active_menu($link) {
      if (preg_match("/" . $link . "/i", Request::segment(2))) {
          return ['menu-open', 'display:block'];
      } else {
        return ['', ''];
      }
    }
}

if(!function_exists('direction')) {

    function direction() {
        if(session()->has('lang')) {
            if (session('lang') == 'ar') {
                return 'rtl';
            } else {
                return 'ltr';
            }
        } else {
            return 'ltr';
        }
    }
}

///////////   Validate Helper function /////////////

if(!function_exists('v_image')) {
    function v_image($extension = null) {

      if ($extension === null) {
        return 'image|mimes:jpg,jpeg,png,gif,bmp';
      } else {
        return 'image|mimes:' . $extension;
      }

    }
}


if(!function_exists('get_parent')) {

    function get_parent($dep_id) {
        $list_department = [];

        $department = \App\Model\Department::find($dep_id);

        if ($department !== null && $department->parent > 0) {
            return get_parent($department->parent) . "," . $dep_id;
        } else {
            return $dep_id;
        }

        


     return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);
  }
}

if(!function_exists('load_dep')) {

    function load_dep($select = null, $dep_hide = null, $dep_decode = null) {
      $departments = \App\Model\Department::selectRaw('depart_name_' . session('lang') . ' as text')
                                          ->selectRaw('id as id')
                                          ->selectRaw('parent as parent')
                                          ->get(['text', 'parent', 'id']);
      $dep_arr = [];
      foreach ($departments as $department) {
        $list_arr             = [];
        $list_arr['icon']     = '';
        $list_arr['li_attr']  = '';
        $list_arr['a_attr']   = '';
        $list_arr['children'] = [];

        if ($select !== null && $select == $department->id) {

          $list_arr['state']    = [
            'opened'   => true,
            'selected' => true,
            'disabled' => false,
          ];
       }

       if ($dep_hide !== null && $dep_hide == $department->id) {

         $list_arr['state']    = [
            'opened'    => false,
            'selected'  => false,
            'disabled'  => true,
            'hidden'    => true,
          ];
       }

       if ($dep_decode !== null && $dep_decode == $department->id) {

         $list_arr['state']    = [
            'opened'    => false,
            'selected'  => false,
            'disabled'  => true,
          ];
       }


       $list_arr['id']     = $department->id;
       $list_arr['parent'] = $department->parent > 0 ? $department->parent : '#';
       $list_arr['text']   = $department->text;

       array_push($dep_arr, $list_arr);

     }

     return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);
  }
}
