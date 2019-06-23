<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ProductsDataTable;
use Illuminate\Http\Request;
use App\Model\Country;
use App\Model\Product;
use App\Model\Size;
use App\Model\Weight;
use App\Http\Controllers\Upload;
use Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $product)
    {
        return $product->render('admin.products.index', ['title' => trans('admin.products')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function repare_weight_size()
    {
        if(request()->ajax() and request()->has('dep_id')) {

            $dep_list = array_diff(explode(',', get_parent(request('dep_id'))), [request('dep_id')]);

            $size_1   = Size::where('is_public', 'yes')->whereIn('department_id', $dep_list)->pluck('name_' . session('lang'), 'id');
            $size_2   = Size::where('department_id', request('dep_id'))->pluck('name_' . session('lang'), 'id');

            $sizes = array_merge(json_decode($size_1, true), json_decode($size_2, true));

            // return $sizes;

            $weights = Weight::pluck('name_' . session('lang'));

            return view('admin.products.ajax.sizes_weights', ['sizes' => $sizes, 'weights' => $weights])->render();

        } else {
            return 'برجاء اختيار قسم';
        }
    }




    public function create()
    {
        $product = Product::create(['title' => '']);

        if (!empty($product)) {

          return redirect(aurl('products/' . $product->id . '/edit'));

        }
    }

    public function update_product_image($id)
    {
        $product = Product::where('id', $id)->update([

          'photo' => Upload::upload([
              'file'         => 'file',
              'path'         => 'public/products/' . $id,
              'upload_type'  => 'single',
              'delete_file'  => '',

          ]),

        ]);

        return response(['status' => true], 200);
    }

    public function delete_main_image($id)
    {
        $product = Product::find($id);
        Storage::delete($product->photo);
        $product->photo = '';
        $product->save();

        return response(['status' => true], 200);
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
          'name_en'          => 'required',
          'name_ar'          => 'required',
          'mob'              => 'required',
          'code'             => 'required',
          'logo'             => 'sometimes|nullable|' . v_image(),
        ], [], [
          'name_en'          => trans('admin.name_en'),
          'name_ar'          => trans('admin.name_ar'),
          'mob'              => trans('admin.mob'),
          'code'             => trans('admin.code'),
          'logo'             => trans('admin.logo'),
        ]);

        if (request()->has('file')) {

            Upload::upload([
                'new_name'     => '',
                'file'         => 'file',
                'path'         => 'public/products',
                'upload_type'  => 'single',
                'delete_file'  => '',

            ]);
        }

        Country::create($data);
        session()->flash('success', trans('admin.record_added'));
        return redirect(aurl('products'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.products.product', ['title' => trans('admin.create_or_edit_products', ['title' => $product->title]), 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function upload_file($id)
     {

       if (request()->hasFile('file')) {

          return Upload::upload([
           'file'         => 'file',
           'path'         => 'products/' . $id,
           'upload_type'  => 'files',
           'file_type'    => 'product',
           'relation_id'  => $id,
         ]);


       }

     }

     public function delete_file()
     {

       if (request()->has('id')) {

             Upload::delete(request('id'));
       }
     }


    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
          'name_en'          => 'required',
          'name_ar'          => 'required',
          'mob'              => 'required',
          'code'             => 'required',
          'logo'             => 'sometimes|nullable|' . v_image(),
        ], [], [
          'name_en'          => trans('admin.name_en'),
          'name_ar'          => trans('admin.name_ar'),
          'mob'              => trans('admin.mob'),
          'code'             => trans('admin.code'),
          'logo'             => trans('admin.logo'),
        ]);

        if (request()->has('logo')) {

            $data['logo'] = Upload::upload([
                'new_name'     => '',
                'file'         => 'logo',
                'path'         => 'public/products',
                'upload_type'  => 'single',
                'delete_file'  => Country::find($id)->logo,

            ]);
        }

        Country::where('id', $id)->update($data);
        session()->flash('success', trans('admin.updated'));
        return redirect(aurl('products'));
    }

    public function multi_delete()
    {
       if (is_array(request('item'))) {
            foreach (request('item') as $id) {
                $product = Country::find($id);
                Storage::delete($product->logo);
                $product->delete();
            }
       } else {
           $product = Country::find($id);
           Storage::delete($product->logo);
           $product->delete();
       }

       session()->flash('success', trans('admin.deleted'));
       return redirect(aurl('products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Country::find($id);
        Storage::delete($product->logo);
        $product->delete();
        session()->flash('success', trans('admin.deleted'));
        return redirect(aurl('products'));
    }
}
