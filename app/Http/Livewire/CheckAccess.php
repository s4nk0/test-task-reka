<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
    public static function checkAccess($access,$array){


        abort_if(Gate::forUser(Auth::user())->denies($access,[$array['model'],$array['otherUser']]), Response::HTTP_FORBIDDEN, 'Нет достпа');
    }
}
