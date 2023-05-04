<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    Filter tags
                    @if(count($filterTags))
                        @foreach($filterTags as $key => $data)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model='selectedTags' value="{{$data}}" id="filterTags-{{$key}}">
                                <label class="form-check-label" for="filterTags-{{$key}}">
                                    {{$data}}
                                </label>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">Empty tags</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Lists</span>
                        <button onclick="Livewire.emit('openModal', 'user.user-list.create', {{ json_encode(['user' => $user->id]) }})" class="btn btn-primary">Create</button>
                    </div>

                    <div class="card-title my-3">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Created</th>
                            <th scope="col">Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if($lists->count())
                            @foreach($lists as $data)
                                <tr>
                                    <th scope="row">
                                        <a {{($data->getFirstMediaUrl()) ? 'href='.$data->getFirstMediaUrl().' target=_blank' : 'href=#' }}  ><img src="{{($data->getFirstMedia()) ? $data->getFirstMedia()->preview_url : 'https://ui-avatars.com/api/?name='.urlencode($data->title).'&color=7F9CF5&background=EBF4FF'}}" height="50" width="50" class="img-thumbnail" alt=""></a>

                                        {{$data->title}}
                                    </th>
                                    <td>{{$data->tags}}</td>
                                    <td>{{$data->created_at}}</td>
                                    <td>
                                        <button onclick="Livewire.emit('openModal', 'user.user-list.update', {{ json_encode(['user_id' => $user->id,'list_id'=>$data->id]) }})" class="btn btn-link  text-primary">  <i class="bi bi-pencil h5"></i></button>
                                        <button wire:click="delete('{{$data->id}}')" class="btn btn-link  text-danger">  <i class="bi bi-trash3 h5"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th scope="row"></th>
                                <td>Пусто</td>
                                <td></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{$lists->links()}}
                </div>
            </div>

        </div>
    </div>


</div>
