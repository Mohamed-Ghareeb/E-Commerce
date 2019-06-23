<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\CountriesDataTable;
use Illuminate\Http\Request;
use App\Model\Country;
use App\Http\Controllers\Upload;
use Storage;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountriesDataTable $country)
    {
        return $country->render('admin.countries.index', ['title' => trans('admin.countries')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create', ['title' => trans('admin.create_countries')]);
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
          'country_name_en'  => 'required',
          'country_name_ar'  => 'required',
          'mob'              => 'required',
          'code'             => 'required',
          'currency'         => 'required',
          'logo'             => 'sometimes|nullable|' . v_image(),
        ], [], [
          'country_name_en'  => trans('admin.country_name_en'),
          'country_name_ar'  => trans('admin.country_name_ar'),
          'mob'              => trans('admin.mob'),
          'code'             => trans('admin.code'),
          'currency'         => trans('admin.currency'),
          'logo'             => trans('admin.logo'),
        ]);

        if (request()->has('logo')) {

            $data['logo'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'logo',
                'path'         => 'public/countries',
                'upload_type'  => 'single',
                'delete_file'  => '',

            ]);
        }

        Country::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('countries'));

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
        $country = Country::find($id);
        $title = trans('admin.edit');
        return view('admin.countries.edit', compact('country', 'title'));
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
          'country_name_en'  => 'required',
          'country_name_ar'  => 'required',
          'mob'              => 'required',
          'code'             => 'required',
          'currency'         => 'required',
          'logo'             => 'sometimes|nullable|' . v_image(),
        ], [], [
          'country_name_en'  => trans('admin.country_name_en'),
          'country_name_ar'  => trans('admin.country_name_ar'),
          'mob'              => trans('admin.mob'),
          'code'             => trans('admin.code'),
          'currency'         => trans('admin.currency'),
          'logo'             => trans('admin.logo'),
        ]);

        if (request()->has('logo')) {

            $data['logo'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'logo',
                'path'         => 'public/countries',
                'upload_type'  => 'single',
                'delete_file'  => Country::find($id)->logo,

            ]);
        }

        Country::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('countries'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $country = Country::find($id);
                Storage::delete($country->logo);
                $country->delete();
            }
       } else {
           $country = Country::find($id);
           Storage::delete($country->logo);
           $country->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('countries'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);
        Storage::delete($country->logo);
        $country->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('countries'));
    }
}
