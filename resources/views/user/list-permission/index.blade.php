@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-header">Permissions given to me</div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Permission</th>
                        <th scope="col">Link</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($givenMePermissions->count())
                        @foreach($givenMePermissions as $data )
                            <tr>
                                <th scope="row">{{$data->user->name}}</th>
                                <td>{{$data->permission->title}}</td>
                                <td><a href="{{route('user.list.index',['user'=>$data->user])}}">Link</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th scope="row">Empty</th>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </div>

        </div><div class="card">
            <div class="card-body">
                <div class="card-header d-flex justify-content-between">
                    <span>Permissions that I gave</span>
                    <a class="btn btn-primary" href="{{route('user.listPermission.create')}}">Create permission</a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">To User</th>
                        <th scope="col">Permission</th>
                        <th scope="col">Link</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($givenPermissions->count())
                        @foreach($givenPermissions as $data )
                            <tr>
                                <th scope="row">{{$data->otherUser->name}}</th>
                                <td>{{$data->permission->title}}</td>
                                <td><a href="{{route('user.list.index',['user'=>$data->user])}}">Link</a></td>
                                <td>
                                    <form action="{{route('user.listPermission.destroy',['listPermission'=>$data])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td></td>
                            <th scope="row">Empty</th>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
