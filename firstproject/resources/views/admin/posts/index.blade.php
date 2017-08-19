@extends('layouts.admin')

@section('content')

    <h1>Posts</h1>

    <table class="table">
        <thead>
          <tr>
              <th>Id</th>
              <th>Photo</th>
              <th>Owner</th>
              <th>Category</th>
              <th>Title</th>
              <th>Body</th>
              <th>Created</th>
              <th>Updated</th>
              <th>Post</th>
              <th>Comment</th>
          </tr>
        </thead>
        <tbody>
        @if($posts)
            @foreach($posts as $post)
              <tr>
                  <td>{{$post->id}}</td>
                  <td><img width="50" height="50" src="{{$post->photo ? $post->photo->path : 'http://placehold.it/50x50'}}" alt="Post photo"></td>
                  <td><a href="{{route('admin.posts.edit',$post->id)}}">{{$post->user->name}}</a></td>
                  <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
                  <td>{{$post->title}}</td>
                  <td>{{str_limit($post->body,20)}}</td>
                  <td>{{$post->created_at->diffForHumans()}}</td>
                  <td>{{$post->updated_at->diffForHumans()}}</td>
                  <td><a href="{{route('home.post',$post->id)}}">View</a></td>
                  <td><a href="{{route('admin.comments.show', $post->id)}}">View</a></td>
              </tr>
       </tbody>
        @endforeach
        @endif
     </table>
     <div class="row">
        <div class="text-center">
            {{$posts->render()}}
        </div>
     </div>
@endsection