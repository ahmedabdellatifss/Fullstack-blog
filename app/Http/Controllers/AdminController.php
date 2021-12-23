<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Category;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // first check if you are loggedin and admin user ...
    //return Auth::check();
    public function index(Request $request)
    {
        if(!Auth::check() && $request->path() != 'login')
        {
            return redirect('/login');
        }
        if(!Auth::check() && $request->path() == 'login')
        {
            return view('welcome');
        }
            // you are already logged in... so check for if you are an admin user..
            $user = Auth::user();
            if ($user->userType == 'User'){
                return redirect('/login');
            }
            if($request->path() == 'login')
            {
                return redirect('/');
            }
            return view('welcome');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }



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


    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request) {
        $fileNme = $request->imageName;
        $this->deleteFileFromServer($fileNme);
        return 'Done';
    }


    public function deleteFileFromServer($fileName , $hasFullPath = false) {
        if (!$hasFullPath) {
            $iflePath = public_path().'/uploads/'.$fileName;
        }
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


    public function getCategory() {
        return Category::orderBy('id', 'desc')->get();
    }


    public function editCategory(Request $request)
    {
       // validate request
        $this->validate($request, [
        'categoryName' => 'required',
        'iconImage' => 'required',
        ]);
        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }

    public function deleteCategory(Request $request)
    {
        // first delete the original file from the server
        $this->deleteFileFromServer($request->iconImage);
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id', $request->id)->delete();
    }

/// crate user

    public function createUser (Request $request)
    {
        // validate request
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email|unique:users',
            // bail mean if record is failed it will not check for email
            'password' => 'bail|required|min:6',
            'userType' => 'required',
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'userType' => $request->userType,
        ]);
        return $user;
    }


    // ######  Edit User  #########

    public function editUser (Request $request)
    {
        // validate request
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id",
            // (email,$request->id) will ignore the email for the user his id = $request->id if he didn't want to change it #20
            //(email,$request->id) mean if user won't to change the email that won't do error validate
            'password' => 'min:6',
            'userType' => 'required',
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'userType' => $request->userType,
        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }
        $user = User::where('id', $request->id)->update($data);
        return $user;
    }

    // get users
    public function getUsers()
    {
        return User::where('userType' , '!=' , 'User')->get();
    }

    ///  Login for Admin

    public function adminLogin(Request $request)
    {
        // validate request
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->userType  == 'User') {
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login details',
                ], 401);
            }
            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login details',
            ], 401);
        }
    }

}
