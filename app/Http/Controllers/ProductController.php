<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $file_img_product =null;
        if ($request->picture){
            $filename_product = 'product-'.$this->generateRandomString();
            $extension = $request->picture->extension();
            $file_img_product = $filename_product.'.'.$extension;
            Storage::putFileAs('product',$request->picture,$file_img_product);
        }
        $validatedData = $request->validated();
        $validatedData['picture'] = $file_img_product;
        $validatedData['create_uid'] = $request->create_uid;
        $post = Product::create($validatedData);
        return new ProductResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('brand:id,name,logo,banner')->findOrFail($id);
        return new ProductDetailResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $file_img_product =$product->picture;
        if ($request->picture){
            if ($product->picture){
                Storage::delete('product/'.$product->picture);
                $filename_product = 'product-'.$this->generateRandomString();
                $extension = $request->picture->extension();
                $file_img_product = $filename_product.'.'.$extension;
                Storage::putFileAs('product',$request->picture,$file_img_product);
            }else{
                $filename_product = 'product-'.$this->generateRandomString();
                $extension = $request->picture->extension();
                $file_img_product = $filename_product.'.'.$extension;
                Storage::putFileAs('product',$request->picture,$file_img_product);
            }

        }
        $validatedData =$request->validated();
        $validatedData['picture'] = $file_img_product;
        $product->update($validatedData);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete('product/'.$product->picture);
        $product->delete();
        return response()->noContent();
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
