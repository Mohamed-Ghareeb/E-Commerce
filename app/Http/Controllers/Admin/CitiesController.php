<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\CitiesDataTable;
use Illuminate\Http\Request;
use App\Model\City;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CitiesDataTable $city)
    {
        return $city->render('admin.cities.index', ['title' => trans('admin.cities')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create', ['title' => trans('admin.create_cities')]);
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
          'city_name_en'  => 'required',
          'city_name_ar'  => 'required',
          'country_id'       => 'required|numeric'

        ], [], [
          'city_name_en'  => trans('admin.city_name_en'),
          'city_name_ar'  => trans('admin.city_name_ar'),
          'country_id'       => trans('admin.country_id'),

        ]);

        City::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('cities'));

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
        $city = City::find($id);
        $title = trans('admin.edit');
        return view('admin.cities.edit', compact('city', 'title'));
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
          'city_name_en'    => 'required',
          'city_name_ar'    => 'required',
          'country_id'      => 'required|numeric'
        ], [], [
          'city_name_en'    => trans('admin.city_name_en'),
          'city_name_ar'    => trans('admin.city_name_ar'),
          'country_id'      => trans('admin.country_id'),

        ]);

        City::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('cities'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $city = City::find($id);
                $city->delete();
            }
       } else {
           $city = City::find($id);
           $city->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('cities'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('cities'));
    }
}
