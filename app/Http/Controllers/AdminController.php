<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addTag(Request $request) {
        // validation
        $this->validate($request , [
            'tagName' => 'required'
        ]);
        return $create = Tag::create([
            'tagName' => $request->tagName
        ]);
    }


    public function editTag(Request $request) {
        // validation
        $this->validate($request , [
            'tagName' => 'required',
            'id' => 'required'
        ]);
        return $create = Tag::where('id' , $request->id)->update([
            'tagName'=>$request->tagName
        ]);

    }


    public function deleteTag(Request $request) {
        // validation
        $this->validate($request , [
            'id' => 'required'
        ]);
        return $create = Tag::where('id' , $request->id)->delete();

    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }


    public function upload(Request $request){
        $this->validate($request , [
            'file' => 'required|mimes:jpeg,bmp,png'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads') , $picName);
        return $picName;
    }


}
