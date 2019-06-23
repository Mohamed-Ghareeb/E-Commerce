<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Setting;
use Storage;
use App\Http\Controllers\Upload;

class Settings extends Controller
{

    public function setting()
    {
        return view('admin.settings', ['title' => trans('admin.settings')]);
    }

    public function setting_save()
    {
        $data = $this->validate(request(),
                      ['logo'                 => v_image(),
                       'icon'                 => v_image(),
                       'status'               => '',
                       'sitename_ar'          => '',
                       'sitename_en'          => '',
                       'description'          => '',
                       'keywords'             => '',
                       'main_lang'            => '',
                       'message_maintenance'  => '',
                      ],
                      [],
                      ['logo' => trans('admin.logo'), 'icon' => trans('admin.icon')]);


        if (request()->has('logo')) {

            $data['logo'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'logo',
                'path'         => 'public/settings',
                'upload_type'  => 'single',
                'delete_file'  => setting()->logo,

            ]);
        }
        if (request()->has('icon')) {

          $data['icon'] = Upload::upload([
              'new_name'     => '',
              'file'         => 'icon',
              'path'         => 'public/settings',
              'upload_type'  => 'single',
              'delete_file'  => setting()->icon,

          ]);
        }
        Setting::orderBy('id', 'desc')->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('settings'));
    }

}
