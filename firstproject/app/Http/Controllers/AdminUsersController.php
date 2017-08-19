<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(2);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        dd($roles = Role::lists('id','name')); provera da li se vraca niz
        $roles = Role::lists('name','id')->all();
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
        Session::flash('create_user','The user has been created');

        if(trim($request->password) == ''){

            $input = $request->except('password');

        }
        else{

            $input = $request->all();
            $input['password'] = bcrypt($request->password);

        }

        // unos podataka sa forme u bazu
//           $input = $request->all();

        if($file = $request->file('file')){

            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
//               dd($photo = Photo::create(['path'=> $name]));
            $photo = Photo::create(['path'=> $name]);
            $input['photo_id'] = $photo->id;

        }

        User::create($input);

        return redirect('/admin/users');

//        return $request->all();
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
        $user = User::findOrFail($id);
        $roles = Role::lists('name','id')->all();
        return view('admin.users.edit',compact('user','roles'));
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
        $user = User::findOrFail($id);

        Session::flash('updated_user','The user has been updated');

        if(trim($request->password) == ''){

            $input = $request->except('password');

        }
        else{

            $input = $request->all();
            $input['password'] = bcrypt($request->password);

        }

        if($file = $request->file('file')){

            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);

            $photo = Photo::create(['path'=> $name]);

            $input['photo_id'] = $photo->id;

        }
        $user->update($input);
        return redirect('/admin/users/');
//        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // brisanje slike korisnika iz foldera uz pomoc funkcije unlink()
        // ne moramo da navodimo ime foldera zato sto smo ga naveli u access-u
        unlink(public_path() . $user->photo->path);

        $user->delete();

        Session::flash('deleted_user','The user has been deleted');

        return redirect('/admin/users');
    }
}
