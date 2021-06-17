<?php

namespace App\Repositories;

use App\Contracts\ProfileInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileRepositories implements ProfileInterface
{
    public function get()
    {
        return Auth::user();
    }

    public function update($request, $id)
    {
       $user = User::findOrFail($id);
        if($request->has('image')){
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $user->image = $imageName;
            $user->save();
        }
        $user->name = $request->name;
        $user->save();
        return $user;
    }
}