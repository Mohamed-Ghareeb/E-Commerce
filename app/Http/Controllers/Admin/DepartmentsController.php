<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
// use App\DataTables\CitiesDataTable;
use Illuminate\Http\Request;
use App\Model\Department;

use Storage;
use \App\Http\Controllers\Upload;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.departments.index', ['title' => trans('admin.departments')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create', ['title' => trans('admin.create_departments')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
          'depart_name_en'  => 'required',
          'depart_name_ar'  => 'required',
          'parent'          => 'sometimes|nullable',
          'icon'            => 'sometimes|nullable|' . v_image(),
          'description'     => 'sometimes|nullable',
          'keywords'        => 'sometimes|nullable',

        ], [], [
          'depart_name_en'  => trans('admin.depart_name_en'),
          'depart_name_ar'  => trans('admin.depart_name_ar'),
          'parent'          => trans('admin.parent'),
          'icon'            => trans('admin.icon'),
          'description'     => trans('admin.description'),
          'keywords'        => trans('admin.keywords'),

        ]);

        if (request()->has('icon')) {
            $data['icon'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'icon',
                'path'         => 'public/departments',
                'upload_type'  => 'single',
                'delete_file'  => '',

            ]);
        }

        Department::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('departments'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        $title = trans('admin.edit');
        return view('admin.departments.edit', compact('department', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $data = $this->validate($request, [
        'depart_name_en'  => 'required',
        'depart_name_ar'  => 'required',
        'parent'          => 'sometimes|nullable',
        'icon'            => 'sometimes|nullable|' . v_image(),
        'description'     => 'sometimes|nullable',
        'keywords'        => 'sometimes|nullable',

      ], [], [
        'depart_name_en'  => trans('admin.depart_name_en'),
        'depart_name_ar'  => trans('admin.depart_name_ar'),
        'parent'          => trans('admin.parent'),
        'icon'            => trans('admin.icon'),
        'description'     => trans('admin.description'),
        'keywords'        => trans('admin.keywords'),

      ]);

      if (request()->has('icon')) {

          $data['icon'] = Upload::upload([
              'new_name'     => '',
              'file'         => 'icon',
              'path'         => 'public/departments',
              'upload_type'  => 'single',
              'delete_file'  => Department::find($id)->icon,

          ]);
      }

        Department::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('departments'));
    }

    public static function delete_parent($id)
    {
      $department_parent = Department::where('parent', $id)->get();

      foreach ($department_parent as $sub) {

          self::delete_parent($sub->id);

          if (!empty($sub->icon)) {
              Storage::has($sub->icon) ? Storage::delete($sub->icon) : "";
          }

          $sub_department = Department::find($sub->id);

          if(!empty($sub_department)) {
            $sub_department->delete();
          }

      }
      $dep = Department::find($id);
      if (!empty($dep->icon)) {
          Storage::has($dep->icon) ? Storage::delete($dep->icon) : "";
      }
      $dep->delete();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::delete_parent($id);
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('departments'));
    }
}
