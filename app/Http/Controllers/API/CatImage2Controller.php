<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

use App\Models\CatImage;

use Response;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class CatImage2Controller extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $catImages = CatImage::all();
        return $this->sendResponse($catImages->toArray(), 'Cat Images retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'title' => 'required',
            //'body' => 'required',
            'image' => 'image|nullable|max:1999'
        ]);

       // Handle File Upload
        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public', $fileNameToStore);
        }


       $catImage = new CatImage;
    //     $catImage->title = $request->input('title');
    //     $catImage->body = $request->input('body');
        // $catImage->user_id = auth()->user()->id;
         $catImage->image = $fileNameToStore;
        $catImage->save();

        return $this->sendResponse($catImage->toArray(), 'Cat Image saved successfully');
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
        $catImage = CatImage::find($id);

        return $this->sendResponse($catImage->toArray(), 'Cat Image saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $this->validate($request, [
            //'title' => 'required',
            //'body' => 'required',
            'image' => 'required|image|max:1999'
        ]);

        $catImage = CatImage::find($id);
        
       // Handle File Upload
       if($request->hasFile('image')){
        // Get filename with the extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('image')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore= $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('image')->storeAs('public', $fileNameToStore);
    }

    if($request->hasFile('image')){
        $catImage->image = $fileNameToStore;
    }



     $catImage->image = $fileNameToStore;
        $catImage->save();

        return $this->sendResponse($catImage->toArray(), 'Cat Image saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
