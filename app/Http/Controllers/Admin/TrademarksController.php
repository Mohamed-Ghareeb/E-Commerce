<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\TrademarkDataTable;
use Illuminate\Http\Request;
use App\Model\Trademark;
use App\Http\Controllers\Upload;
use Storage;

class TrademarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TrademarkDataTable $trade)
    {
        return $trade->render('admin.trademarks.index', ['title' => trans('admin.trademarks')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.trademarks.create', ['title' => trans('admin.create_trademarks')]);
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
          'name_en'  => 'required',
          'name_ar'  => 'required',
          'logo'     => 'sometimes|nullable|' . v_image(),
        ], [], [
          'name_en'  => trans('admin.name_en'),
          'name_ar'  => trans('admin.name_ar'),
          'logo'     => trans('admin.logo'),
        ]);

        if (request()->has('logo')) {

            $data['logo'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'logo',
                'path'         => 'public/trademarks',
                'upload_type'  => 'single',
                'delete_file'  => '',

            ]);
        }

        Trademark::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('trademarks'));

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
        $trade = Trademark::find($id);
        $title = trans('admin.edit');
        return view('admin.trademarks.edit', compact('trade', 'title'));
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
          'name_en'  => 'required',
          'name_ar'  => 'required',
          'logo'     => 'sometimes|nullable|' . v_image(),
        ], [], [
          'name_en'  => trans('admin.name_en'),
          'name_ar'  => trans('admin.name_ar'),
          'logo'     => trans('admin.logo'),
        ]);

        if (request()->has('logo')) {

            $data['logo'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'logo',
                'path'         => 'public/trademarks',
                'upload_type'  => 'single',
                'delete_file'  => Trademark::find($id)->logo,

            ]);
        }

        Trademark::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('trademarks'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $trade = Trademark::find($id);
                Storage::delete($trade->logo);
                $trade->delete();
            }
       } else {
           $trade = Trademark::find($id);
           Storage::delete($trade->logo);
           $trade->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('trademarks'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trade = Trademark::find($id);
        Storage::delete($trade->logo);
        $trade->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('trademarks'));
    }
}
