@extends('layouts.admin')
@section('content')

    <h1>Media</h1>

    @if($photos)
        <form action="{{route('admin.delete.media')}}" method="post" class="form-inline">
            {{csrf_field()}}
            {{method_field('delete')}}
            {{--<div class="form-group">--}}
                {{--<select name="checkBoxArray" id="" class="form-control">--}}
                    {{--<option value="delete">Delete</option>--}}
                {{--</select>--}}
            {{--</div>--}}
            <div class="row">
                <input type="submit" value="Single / Multiple Delete" class="btn btn-danger pull-right">
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th class="btn btn-success display"><input type="checkbox" id="options"> Select</th>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Created</th>
                    <th>Image path</th>
                </tr>
                </thead>
                <tbody>
                @foreach($photos as $photo)
                    <tr>
                        <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}"></td>
                        <td>{{$photo->id}}</td>
                        <td><img height="50" width="50" src="{{$photo->path}}" alt="Photos"></td>
                        <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'No date'}}</td>
                        <td>{{$photo->path}}</td>
                        {{--korisceno kad smo imali samo dugme za brisanje pored svake slike--}}
                        {{--<td>--}}
                            {{--{!! Form::open(['method'=>'DELETE','action'=>['AdminMediasController@destroy', $photo->id]]) !!}--}}
                                {{--{!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}--}}
                            {{--{!! Form::close() !!}--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>
        <div class="row">
            <div class="text-center">
                {{$photos->render()}}
            </div>
        </div>
    @endif
@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $('#options').click(function () {
                if(this.checked){

                    $('.checkBoxes').each(function () {
                        this.checked = true;
                    });
                }
                else {
                    $('.checkBoxes').each(function () {
                        this.checked = false;
                    });
                }
            });
        });
    </script>

@endsection