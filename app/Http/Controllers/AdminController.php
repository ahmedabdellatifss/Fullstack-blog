<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Category;

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
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads') , $picName);
        return $picName;
    }

    public function deleteImage(Request $request) {
        $fileNme = $request->imageName;
        $this->deleteFileFromServer($fileNme);
        return 'Done';
    }


    public function deleteFileFromServer($fileName) {
        $iflePath = public_path().'/uploads/'.$fileName;
        if(file_exists($iflePath)){
            @unlink($iflePath);
        }
        return;

    }


    public function addCategory(Request $request) {
         // validation
        $this->validate($request , [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        return $create = Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }


    public function getCagegory() {
        return Category::orderBy('id', 'desc')->get();
    }

}
