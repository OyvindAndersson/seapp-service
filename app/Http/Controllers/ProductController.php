<?php

namespace App\Http\Controllers;

use App\Product;
use App\Rules\AlphaNumSpecial;
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

        return $this->sendResponse($resource);
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
        $validator = Validator::make($request->all(), [
            'code' => ['string', 'unique:products', new AlphaNumSpecial],
            'ean' => ['string', 'unique:products', new AlphaNumSpecial],
            'name' => ['string', 'min:3', 'max:64', new AlphaNumSpecial],
            'description' => ['string', 'max:1024', new AlphaNumSpecial],
            'product_group_id' => 'integer|exists:product_groups,id',
            'image_file_id' => 'integer|exists:files,id',
            'supplier_id' => 'integer|exists:suppliers,id',
            'primary_price_id' => 'integer|exists:product_prices,id',

            // todo: Prices relation
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $resource = Product::findOrFail($id);

        $data = $request->all();

        $resource->fill($data);

        $resource->save();

        return $this->sendResponse($resource);
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

        $result = $resource->delete();

        return $this->sendResponse($result);
    }
}
