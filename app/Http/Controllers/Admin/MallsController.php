<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\MallsDataTable;
use Illuminate\Http\Request;
use App\Model\Mall;
use App\Http\Controllers\Upload;
use Storage;

class MallsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MallsDataTable $mall)
    {
        return $mall->render('admin.malls.index', ['title' => trans('admin.malls')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.malls.create', ['title' => trans('admin.create_malls')]);
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
          'name_en'       => 'required',
          'name_ar'       => 'required',
          'mobile'        => 'required|numeric',
          'email'         => 'required|email',
          'country_id'    => 'required|numeric',
          'address'       => 'sometimes|nullable',
          'facebook'      => 'sometimes|nullable|url',
          'twitter'       => 'sometimes|nullable|url',
          'website'       => 'sometimes|nullable|url',
          'contact_name'  => 'sometimes|nullable|string',
          'lat'           => 'sometimes|nullable',
          'lng'           => 'sometimes|nullable',
          'icon'          => 'sometimes|nullable|' . v_image(),
        ], [], [
          'name_en'       => trans('admin.name_en'),
          'name_ar'       => trans('admin.name_ar'),
          'mobile'        => trans('admin.mobile'),
          'email'         => trans('admin.email'),
          'country_id'    => trans('admin.country_id'),
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
                'path'         => 'public/malls',
                'upload_type'  => 'single',
                'delete_file'  => '',

            ]);
        }

        Mall::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('malls'));

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
        $mall = Mall::find($id);
        $title = trans('admin.edit');
        return view('admin.malls.edit', compact('mall', 'title'));
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
          'name_en'       => 'required',
          'name_ar'       => 'required',
          'mobile'        => 'required|numeric',
          'email'         => 'required|email',
          'country_id'    => 'required|numeric',
          'address'       => 'sometimes|nullable',
          'facebook'      => 'sometimes|nullable|url',
          'twitter'       => 'sometimes|nullable|url',
          'website'       => 'sometimes|nullable|url',
          'contact_name'  => 'sometimes|nullable|string',
          'lat'           => 'sometimes|nullable',
          'lng'           => 'sometimes|nullable',
          'icon'          => 'sometimes|nullable|' . v_image(),
        ], [], [
          'name_en'       => trans('admin.name_en'),
          'name_ar'       => trans('admin.name_ar'),
          'mobile'        => trans('admin.mobile'),
          'email'         => trans('admin.email'),
          'country_id'    => trans('admin.country_id'),
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
                'path'         => 'public/malls',
                'upload_type'  => 'single',
                'delete_file'  => Mall::find($id)->icon,

            ]);
        }

        Mall::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('malls'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $mall = Mall::find($id);
                Storage::delete($mall->icon);
                $mall->delete();
            }
       } else {
           $mall = Mall::find($id);
           Storage::delete($mall->icon);
           $mall->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('malls'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mall = Mall::find($id);
        Storage::delete($mall->icon);
        $mall->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('malls'));
    }
}
