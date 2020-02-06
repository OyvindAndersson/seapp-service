<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends ApiResponseController
{
    
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = request()->input('limit');
        $id = request()->input('id');

        if(is_array($id))
        {
            $resources = Product::findMany($id);
        }
        else if(!is_null($id))
        {
            $resources = Product::find($id);
        }
        else
        {
            $resources = Product::limit($limit)->get();
        }
        

        return $resources;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        $resource = new Product(request()->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|alpha_num|unique:products',
            'ean' => 'required|alpha_num|unique:products',
            'name' => 'required|string|min:3|max:64|alpha_num',
            'description' => 'string|max:1024|alpha_num',
            'product_group_id' => 'required|integer|exists:product_groups,id',
            'image_file_id' => 'nullable|integer|exists:files,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'primary_price_id' => 'nullable|integer|exists:product_prices,id',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $resource = new Product();

        $data = $request->all();

        $resource->fill($data);

        $resource->save();

        return $resource;
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = Product::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = Product::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, []);

        $resource = Product::findOrFail($id);

        $data = $request->all();

        $resource->fill($data);

        $resource->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = Product::findOrFail($id);

        $resource->delete();
    }
}
