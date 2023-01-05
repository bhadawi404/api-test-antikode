<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutletRequest;
use App\Models\Outlet;
use App\Http\Resources\OutletResource;
use App\Http\Resources\OutletDetailResource;
use Illuminate\Support\Facades\Storage;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OutletResource::collection(Outlet::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOutletRequest $request)
    {
        $file_img_outlet =null;
        if ($request->picture){
            $filename_outlet = 'outlet-'.$this->generateRandomString();
            $extension = $request->picture->extension();
            $file_img_outlet = $filename_outlet.'.'.$extension;
            Storage::putFileAs('outlet',$request->picture,$file_img_outlet);
        }
        $validatedData = $request->validated();
        $validatedData['picture'] = $file_img_outlet;
        $validatedData['create_uid'] = $request->create_uid;
        $post = Outlet::create($validatedData);
        return new OutletResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $outlet = Outlet::with('brand:id,name,logo,banner')->findOrFail($id);
        return new OutletDetailResource($outlet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOutletRequest $request, Outlet $outlet)
    {
        $file_img_outlet =$outlet->picture;
        if ($request->picture){
            if ($outlet->picture){
                Storage::delete('outlet/'.$outlet->picture);
                $filename_outlet = 'outlet-'.$this->generateRandomString();
                $extension = $request->picture->extension();
                $file_img_outlet = $filename_outlet.'.'.$extension;
                Storage::putFileAs('outlet',$request->picture,$file_img_outlet);
            }else{
                $filename_outlet = 'outlet-'.$this->generateRandomString();
                $extension = $request->picture->extension();
                $file_img_outlet = $filename_outlet.'.'.$extension;
                Storage::putFileAs('outlet',$request->picture,$file_img_outlet);
            }

        }
        $validatedData =$request->validated();
        $validatedData['picture'] = $file_img_outlet;
        $outlet->update($validatedData);
        return new OutletResource($outlet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outlet $outlet)
    {
        Storage::delete('outlet/'.$outlet->picture);
        $outlet->delete();
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
