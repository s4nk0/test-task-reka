@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-header">Create permission</div>
                <form action="{{route('user.listPermission.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="other_user_id" class="form-label">Select user</label>
                        <select name="other_user_id" class="form-select" id="other_user_id">
                            @if($users->count())
                                @foreach($users as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            @else
                                <option disabled selected>Empty</option>
                            @endif
                        </select>

                         </div>
                    <div class="mb-3">
                        <label for="permission_id" class="form-label">Select permission</label>
                        <select name="permission_id" class="form-select" id="permission_id">
                            @if($permissions->count())
                                @foreach($permissions as $data)
                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                @endforeach
                            @else
                                <option disabled selected>Empty</option>
                            @endif
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
