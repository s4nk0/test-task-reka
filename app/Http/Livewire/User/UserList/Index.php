<?php

namespace App\Http\Livewire\User\UserList;

use App\Http\Livewire\CheckAccess;
use App\Models\User;
use App\Models\UserList;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $user;
    public $search = '';
    public $filterTags;
    public $selectedTags = [];

    protected $listeners = ['user-list-index-refresh' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedTags()
    {
        $this->resetPage();
    }

    public function mount(User $user){
        CheckAccess::checkAccess('viewAll',['model'=>UserList::class,'otherUser'=>$user]);
        $this->user = $user;
    }

    public function delete($list_id){
        $userList = UserList::find($list_id);
        CheckAccess::checkAccess('delete',['model'=>$userList,'otherUser'=>$this->user]);
        $userList->delete();
        $this->emit('$refresh');
    }

    public function render()
    {
        $lists = UserList::search($this->search)
            ->query(function($query) {
                $query->where('user_id',$this->user->id)->orderBy('created_at','desc');
                if (count($this->selectedTags)){
                    foreach ($this->selectedTags as $data){
                        if ($data != null){
                            $query->where('tags','like','%'.$data.'%');
                        }
                    }
                }
            })->paginate(5);

        $filterTags = (array_filter($this->user->lists()->pluck('tags')->toArray(), fn($value) => !is_null($value) && $value !== ''));
        $merged_array = [];
        foreach ($filterTags as $string) {
            $words = explode(", ", $string);
            $merged_array = array_merge($merged_array, $words);
        }
        $this->filterTags = array_unique($merged_array);

        return view('livewire.user.user-list.index',compact('lists'))->layout('layouts.app');
    }
}
