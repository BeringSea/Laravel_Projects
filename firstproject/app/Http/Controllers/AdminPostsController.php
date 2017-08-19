<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\CommentReply;
use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(2);
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::lists('name', 'id')->all();

        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();

        $user = Auth::user(); // ulogovan korisnik ciji id prosedjujemo u posts tabelu

        if($file = $request -> file('photo_id')){

            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
            $photo = Photo::create(['path'=>$name]);
            $input['photo_id'] = $photo->id;
        }

        $user->post()->create($input);

        return redirect('/admin/posts');

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
        $post = Post::findOrFail($id);

        $categories = Category::lists('name','id')->all();

        return view('admin.posts.edit',compact('post','categories'));
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
        $input = $request->all();
        $post = Post::findOrFail($id);

        if($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
            $photo = Photo::create(['path'=>$name]);
            $input['photo_id'] = $photo->id;
        }
//        dd($input);
//        Auth::user()->post()->where('id',$id)->first()->update($input);
        $post->update($input);
        return redirect('/admin/posts');
//        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        unlink(public_path() . $post->photo->path);

        $post->delete();

        return redirect('/admin/posts');
    }

    public function post($id){

        $post = Post::findOrFail($id);

        $comments = $post->comments()->where('is_active',1)->get();


        // moze i ovako da se izvuce id za reply ali je uredjeno na stranici
//        $replies = CommentReply::findOrFail($id);

        return view('post',compact('post','comments'));

//        return "it works";
//        dd($comments);

    }
}
