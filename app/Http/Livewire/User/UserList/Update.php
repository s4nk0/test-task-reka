<?php

namespace App\Http\Livewire\User\UserList;

use App\Http\Livewire\CheckAccess;
use App\Models\User;
use App\Models\UserList;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Update extends ModalComponent
{
    use WithFileUploads;

    public $list_id;
    public $user_id;
    public $title;
    public $description;
    public $media;
    public $list;
    public $tags = [];
    public $tag;


    public function rules(){
        return [
            'title'=>'required|string',
            'description'=>'nullable|string',
            'media'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function mount($user_id,$list_id){

        $this->list_id = $list_id;
        $this->user_id = $user_id;
        $this->list = UserList::find($this->list_id);
        $this->title = $this->list->title;
        $this->description = $this->list->description;
        $this->tags = $this->list->getTags();
        CheckAccess::checkAccess('update',['model'=>$this->list,'otherUser'=>User::find($this->user_id)]);

    }

    public function save(){

        CheckAccess::checkAccess('update',['model'=>$this->list,'otherUser'=>User::find($this->user_id)]);


        $this->list ->update([
            'title'=>$this->title,
            'description'=>$this->description,
        ]);

        if ($this->media){
            $this->list->addMedia($this->media)
                ->toMediaCollection();
        }

        if (count($this->tags)){
            $this->list->updateTags($this->tags);
        }

        $this->emit('user-list-index-refresh');
        $this->closeModal();
    }

    public function deletePhoto(){
        $this->list->clearMediaCollection();
        $this->emit('user-list-index-refresh');
        $this->closeModal();
    }


    public function addTag(){
        if ($this->tag != ''){
            array_push($this->tags, $this->tag);
            $this->tag = '';
        }

    }

    public function deleteTag($tag){
        if (count($this->tags)){
            $this->tags = array_diff( $this->tags, [$tag] );
        }

    }

    public function render()
    {

        return view('livewire.user.user-list.update');
    }
}
