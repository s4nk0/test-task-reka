<?php

namespace App\Http\Livewire\User\UserList;

use App\Http\Livewire\CheckAccess;
use App\Models\User;
use App\Models\UserList;
use App\Rules\FitnessCard\FitnessCardExistsCheckRule;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $user_id;
    public $title;
    public $description;
    public $media;
    public $tags = [];
    public $tag;


    public function rules(){
        return [
            'title'=>'required|string',
            'description'=>'nullable|string',
            'media'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($user){

        CheckAccess::checkAccess('create',['model'=>UserList::class,'otherUser'=>User::find($user)]);
        $this->user_id = $user;
    }

    public function save(){
        CheckAccess::checkAccess('create',['model'=>UserList::class,'otherUser'=>User::find($this->user_id)]);
        $userList = UserList::create([
            'user_id'=>$this->user_id,
            'title'=>$this->title,
            'description'=>$this->description,
        ]);
        if ($this->media){
            $userList->addMedia($this->media)
                ->toMediaCollection();
        }
        if (count($this->tags)){
            $userList->updateTags($this->tags);
        }


        $this->emit('user-list-index-refresh');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.user.user-list.create');
    }
}
