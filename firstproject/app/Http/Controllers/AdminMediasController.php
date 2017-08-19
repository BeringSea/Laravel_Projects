<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

use App\Http\Requests;
use function Sodium\compare;

class AdminMediasController extends Controller
{
    public function index(){

//        dd($photos = Photo::all());
        $photos = Photo::paginate(5);
        return view('admin.media.index',compact('photos'));

    }

    public function create(){

        return view('admin.media.create');

    }

    public function store(Request $request){

        // po difultu dropzona kljuc je pod nazivom 'file'
        $file = $request->file('file');

        $name = time() . $file->getClientOriginalName();

        $file->move('images',$name);

        Photo::create(['path'=>$name]);
    }

    public function destroy($id){

        $photo = Photo::findOrFail($id);

        unlink(public_path() . $photo->path);

        $photo->delete();

        return redirect('admin/media');

    }

    public function deleteMedia(Request $request){

        if(!empty($request->checkBoxArray)){
            $photos = Photo::findOrFail($request->checkBoxArray);
            foreach ($photos as $photo){
//            unlink(public_path() . $photo->path);
                $photo->delete();
            }
            return redirect()->back();
        }
        else{
            return redirect()->back();
        }

    }
}
