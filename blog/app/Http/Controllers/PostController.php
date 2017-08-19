<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
    public function getBlogIndex(){

        $posts = Post::orderBy('created_at','desc')->paginate(5);
        foreach ($posts as $post){
            $post->body = $this->shortenText($post->body, 20);
        }
        return view('frontend.blog.index',compact('posts'));

    }

    public function getPostIndex(){
        $posts = Post::paginate(5);
        return view('admin.blog.index',compact('posts'));
    }

    public function getSinglePost($post_id, $end = 'frontend'){

        $post = Post::findOrFail($post_id);
        if(!$post){
            return redirect()->route('blog.index')->with(['fail'=>'Post not found!']);
        }
        return view($end .'.blog.single',compact('post'));

    }

    public function getUpdatePost($post_id){
        $post = Post::findOrFail($post_id);
        $categories = Category::all();
        $post_categories = $post->categories;
        $post_categories_ids = array();
        $i=0;
        foreach ($post_categories as $post_category){
            $post_categories_ids[$i] = $post_category->id;
            $i++;
        }
        if(!$post){
            return redirect()->route('blog.index')->with(['fail'=>'Post not found!']);
        }
        // Find categories
        return view('admin.blog.edit_post',compact('post','categories','post_categories','post_categories_ids'));
    }

    public function getCreatePost(){
        $categories = Category::all();
        return view('admin.blog.create_post',compact('categories'));
    }

    public function postCreatePost(Request $request){
        $this->validate($request,[
            'title'     => 'required|max:120|unique:posts',
            'author'    => 'required|max:80',
            'body'      =>' required'
        ]);

        $post = new Post();
        $post->title = $request['title'];
        $post->author = $request['author'];
        $post->body = $request['body'];
        $post->save();
        // Attaching categories
        if(strlen($request['categories']) > 0){
            $categoryIDs = explode(',', $request['categories']);
            foreach ($categoryIDs as $categoryID){
                $post->categories()->attach($categoryID);
            }
        }

        return redirect()->route('admin.index')->with(['success'=>'Post successfully created!']);
    }

    public function postUpdatePost(Request $request){
        $this->validate($request,[
            'title'  => 'required|max:120',
            'author' => 'required|max:80',
            'body'   => 'required'
        ]);
        $post = Post::findOrFail($request['post_id']);
        $post->title = $request['title'];
        $post->author = $request['author'];
        $post->body = $request['body'];

        $post->update();
        //Categories ...
        $post->categories()->detach();
        // Attaching categories
        if(strlen($request['categories']) > 0){
            $categoryIDs = explode(',', $request['categories']);
            foreach ($categoryIDs as $categoryID){
                $post->categories()->attach($categoryID);
            }
        }

        return redirect()->route('admin.index')->with(['success'=>'Post successfully updated']);
    }

    public function getDeletePost($post_id){
        $post = Post::findOrFail($post_id);
        if(!$post){
            return redirect()->route('blog.index')->with(['fail'=>'Post not found!']);
        }
        $post->delete();
        return redirect()->route('admin.index')->with(['success'=>'Post successfully deleted']);
    }

    private function shortenText($text, $words_count){
        if(str_word_count($text,0) > $words_count){
            $words = str_word_count($text,2);
            $pos = array_keys($words);
            $text = substr($text,0, $pos[$words_count]).'...';
        }
        return $text;
    }

}
















