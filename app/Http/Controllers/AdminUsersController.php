<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use Illuminate\Support\Facades\Session;

use App\Photo;
use App\User;
use App\Role;
use App\Http\Requests;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
        {
            //
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $roles = Role::lists('name', 'id')->all();


        return view('admin.users.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //

        if(trim($request->password) == ''){
            //request everything except password field
            $input = $request->except('password'); 
        } else {
            $input = $request->all();
             // encrypte password field
        $input['password'] = bcrypt($request->password);
        }

        if($file = $request->file('photo_id')){
            
            //get the photo anme and get a time appending to it 
            $name = time() . $file->getClientOriginalName();

            // move file to images folder if there is no file its gonna create the file and name is the second parameter
            $file->move('images', $name);

            // create the file and have a photo variable available to it
            $photo = Photo::create(['path'=>$name]);

            $input['photo_id'] = $photo->id;
        }


        User::create($input);

        Session::flash('created_user', 'The user  has been created');

        return redirect('/admin/users');


        // return $request->all();
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

        $user = User::findOrFail($id);

        $roles = Role::lists('name', 'id')->all();

        return view('admin.users.edit', compact('user', 'roles'));

    }

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

        if(trim($request->password) == ''){
            //request everything except password field
            $input = $request->except('password'); 
        } else {
            $input = $request->all();
             // encrypte password field
        $input['password'] = bcrypt($request->password);
        }

        
        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['path'=>$name]);
            $input['photo_id'] = $photo->id;

        }

        Session::flash('updated_user', 'The user  has been updated');


        $user->update($input);

        return redirect('/admin/users');
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
        $user = User::findOrFail($id);

        unlink(public_path() . $user->photo->path);

        $user->delete();

        Session::flash('deleted_user', 'The user  has been deleted');

        return redirect('/admin/users');
    }
}
