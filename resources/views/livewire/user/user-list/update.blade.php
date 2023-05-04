<div>
    <form wire:submit.prevent="save">
        <a {{($list->getFirstMediaUrl()) ? 'href='.$list->getFirstMediaUrl().' target=_blank' : 'href=#' }}  ><img src="{{($list->getFirstMedia()) ? $list->getFirstMedia()->preview_url : 'https://ui-avatars.com/api/?name='.urlencode($list->title).'&color=7F9CF5&background=EBF4FF'}}" height="50" width="50" class="img-thumbnail" alt=""></a>
        @if($list->getFirstMediaUrl())
            <button wire:click.prevent="deletePhoto" class="btn btn-link text-danger">Delete photo</button>
        @endif
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"  wire:model="title">
            <div id="title" class="invalid-feedback">
                @error('title')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control  @error('description') is-invalid @enderror" name="description"  id="description" cols="20" rows="5"  wire:model="description"></textarea>
            <div id="description" class="invalid-feedback">
                @error('description')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="media" class="form-label">Photo</label>
            <div
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
            >
                <!-- File Input -->
                <input type="file" id="media"  class="form-control @error('media') is-invalid @enderror"  wire:model="media">

                <!-- Progress Bar -->
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>
            <div wire:loading wire:target="media">Uploading...</div>
            <div id="media" class="invalid-feedback" style="display: block">
                @error('media')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="tags">Tags</label>
            <input id="tags" type="text" class="form-control mb-3" wire:model="tag" wire:keydown.enter.prevent="addTag">
            <div id="tags" class="form-text">Write text and press the enter to add tag</div>
            @foreach($tags  as $data)
                <div class="badge bg-secondary" wire:click.prevent="deleteTag('{{$data}}')">
                    {{$data}} x
                </div>
            @endforeach
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
