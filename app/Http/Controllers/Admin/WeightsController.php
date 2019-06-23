<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\WeightsDataTable;
use Illuminate\Http\Request;
use App\Model\Weight;

class WeightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(WeightsDataTable $weight)
    {
        return $weight->render('admin.weights.index', ['title' => trans('admin.weights')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.weights.create', ['title' => trans('admin.create_weights')]);
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

        ], [], [
          'name_en'       => trans('admin.name_en'),
          'name_ar'       => trans('admin.name_ar'),

        ]);


        Weight::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('weights'));

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
        $weight = Weight::find($id);
        $title = trans('admin.edit');
        return view('admin.weights.edit', compact('weight', 'title'));
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

        ], [], [
          'name_en'       => trans('admin.name_en'),
          'name_ar'       => trans('admin.name_ar'),

        ]);

        Weight::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('weights'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $weight = Weight::find($id);
                $weight->delete();
            }
       } else {
           $weight = Weight::find($id);
           $weight->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('weights'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weight = Weight::find($id);
        $weight->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('weights'));
    }
}
