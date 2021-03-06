<?php

namespace App\Http\Controllers;
use App\Photo;
use App\User;
use App\Role;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Http\Middleware\Admin;
//use App\Http\Middleware\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use File;
//use App\Http\Controllers\Auth;


class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //display all users
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }



    /**************************create***************************** */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //using pluck() in laravel 5.3 instead of lists()
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }


    /*****************store****************************** */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(UsersRequest $request)
    {
        //


        if (trim($request->password) == ''){

            $input =$request->except('password');
        }else{

            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }
       //User::create($request->all());
      

       if ($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();  //get file name
            $file->move('images', $name);  //move file to images folder

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;


       }
       //encript password
      
       User::create($input);

       Session::flash('created_user', 'The user has been created');

        return redirect('/admin/users');

        //return $request->all();
    }

/**************show******************** */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('admin.users.show');
    }


/***********************edit************************************ */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        //using pluck() in laravel 5.3 instead of lists()
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit',compact('user','roles'));
    }


/**************************update*********************************** */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //
        $user = User::findOrFail($id);


        if (trim($request->password) == ''){

            $input =$request->except('password');
        }else{

            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }


        

        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;
        }
        $user->update($input);
        return redirect('/admin/users');
    }



    /*****************destroy********************** */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);
        if(isset($user->photo->file)){
             //Delete image file in Images folder

        unlink(public_path() . $user->photo->file);

        }
       

        $user->delete();

        Session::flash('deleted_user', 'The user has been deleted');
        return redirect('/admin/users');
    }
}
