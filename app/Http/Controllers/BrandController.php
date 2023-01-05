<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BrandResource::collection(Brand::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $file_img_logo =null;
        $file_img_banner = null;
        if ($request->logo){
            $filename_logo = 'logo-'.$this->generateRandomString();
            $extension = $request->logo->extension();
            $file_img_logo = $filename_logo.'.'.$extension;
            Storage::putFileAs('logo',$request->logo,$file_img_logo);
        }
        if ($request->banner){
            $filename_banner = 'banner-'.$this->generateRandomString();
            $extension = $request->banner->extension();
            $file_img_banner = $filename_banner.'.'.$extension;
            Storage::putFileAs('banner',$request->banner,$file_img_banner);
        }
        $validatedData = $request->validated();
        $validatedData['logo'] = $file_img_logo;
        $validatedData['banner'] = $file_img_banner;
        $validatedData['create_uid'] = $request->create_uid;
        $post = Brand::create($validatedData);
        return new BrandResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::with(['outlets','products'])->findOrFail($id);
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBrandRequest $request, Brand $brand)
    {
        $file_img_logo =$brand->logo;
        $file_img_banner = $brand->banner;
        if ($request->logo){
            if ($brand->logo){
                Storage::delete('logo/'.$brand->logo);
                $filename_logo = 'logo-'.$this->generateRandomString();
                $extension = $request->logo->extension();
                $file_img_logo = $filename_logo.'.'.$extension;
                Storage::putFileAs('logo',$request->logo,$file_img_logo);
            }else{
                $filename_logo = 'logo-'.$this->generateRandomString();
                $extension = $request->logo->extension();
                $file_img_logo = $filename_logo.'.'.$extension;
                Storage::putFileAs('logo',$request->logo,$file_img_logo);
            }

        }

        if ($request->banner){
            if ($brand->banner){
                Storage::delete('banner/'.$brand->banner);
                $filename_banner = 'banner-'.$this->generateRandomString();
                $extension = $request->banner->extension();
                $file_img_banner = $filename_banner.'.'.$extension;
                Storage::putFileAs('banner',$request->banner,$file_img_banner);
            }else{
                $filename_banner = 'banner-'.$this->generateRandomString();
                $extension = $request->banner->extension();
                $file_img_banner = $filename_banner.'.'.$extension;
                Storage::putFileAs('banner',$request->banner,$file_img_banner);
            }

        }

        $validatedData =$request->validated();
        $validatedData['logo'] = $file_img_logo;
        $validatedData['banner'] = $file_img_banner;
        $validatedData['create_uid'] = $request->create_uid;
        $brand->update($validatedData);
        return new BrandResource($brand);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Storage::delete('logo/'.$brand->logo);
        Storage::delete('banner/'.$brand->banner);
        $brand->delete();
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
