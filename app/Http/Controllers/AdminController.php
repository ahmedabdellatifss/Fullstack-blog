<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addTag(Request $request) {
        // validation
        return $create = Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getTag() {
        return Tag::orderBy('id','desc')->get();
    }
}
