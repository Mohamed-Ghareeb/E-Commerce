<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ManufactureDataTable;
use Illuminate\Http\Request;
use App\Model\Manufacture;
use App\Http\Controllers\Upload;
use Storage;

class ManufacturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManufactureDataTable $manufacture)
    {
        return $manufacture->render('admin.manufactures.index', ['title' => trans('admin.manufactures')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manufactures.create', ['title' => trans('admin.create_manufactures')]);
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
          'man_name_en'   => 'required',
          'man_name_ar'   => 'required',
          'mobile'        => 'required|numeric',
          'email'         => 'required|email',
          'address'       => 'required',
          'facebook'      => 'sometimes|nullable|url',
          'twitter'       => 'sometimes|nullable|url',
          'website'       => 'sometimes|nullable|url',
          'contact_name'  => 'sometimes|nullable|string',
          'lat'           => 'sometimes|nullable',
          'lng'           => 'sometimes|nullable',
          'icon'          => 'sometimes|nullable|' . v_image(),
        ], [], [
          'man_name_en'   => trans('admin.name_en'),
          'man_name_ar'   => trans('admin.name_ar'),
          'mobile'        => trans('admin.mobile'),
          'email'         => trans('admin.email'),
          'address'       => trans('admin.address'),
          'facebook'      => trans('admin.facebook'),
          'twitter'       => trans('admin.twitter'),
          'website'       => trans('admin.website'),
          'contact_name'  => trans('admin.contact_name'),
          'lat'           => trans('admin.lat'),
          'lng'           => trans('admin.lng'),
          'icon'          => trans('admin.icon'),
        ]);

        if (request()->has('icon')) {

            $data['icon'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'icon',
                'path'         => 'public/manufactures',
                'upload_type'  => 'single',
                'delete_file'  => '',

            ]);
        }

        Manufacture::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('manufactures'));

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
        $manufacture = Manufacture::find($id);
        $title = trans('admin.edit');
        return view('admin.manufactures.edit', compact('manufacture', 'title'));
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
          'man_name_en'   => 'required',
          'man_name_ar'   => 'required',
          'mobile'        => 'required|numeric',
          'email'         => 'required|email',
          'address'       => 'sometimes|nullable',
          'facebook'      => 'sometimes|nullable|url',
          'twitter'       => 'sometimes|nullable|url',
          'website'       => 'sometimes|nullable|url',
          'contact_name'  => 'sometimes|nullable|string',
          'lat'           => 'sometimes|nullable',
          'lng'           => 'sometimes|nullable',
          'icon'          => 'sometimes|nullable|' . v_image(),
        ], [], [
          'man_name_en'   => trans('admin.name_en'),
          'man_name_ar'   => trans('admin.name_ar'),
          'mobile'        => trans('admin.mobile'),
          'email'         => trans('admin.email'),
          'address'       => trans('admin.address'),
          'facebook'      => trans('admin.facebook'),
          'twitter'       => trans('admin.twitter'),
          'website'       => trans('admin.website'),
          'contact_name'  => trans('admin.contact_name'),
          'lat'           => trans('admin.lat'),
          'lng'           => trans('admin.lng'),
          'icon'          => trans('admin.icon'),
        ]);

        if (request()->has('icon')) {

            $data['icon'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'icon',
                'path'         => 'public/manufactures',
                'upload_type'  => 'single',
                'delete_file'  => Manufacture::find($id)->icon,

            ]);
        }

        Manufacture::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('manufactures'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $manufacture = Manufacture::find($id);
                Storage::delete($manufacture->icon);
                $manufacture->delete();
            }
       } else {
           $manufacture = Manufacture::find($id);
           Storage::delete($manufacture->icon);
           $manufacture->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('manufactures'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacture = Manufacture::find($id);
        Storage::delete($manufacture->icon);
        $manufacture->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('manufactures'));
    }
}
