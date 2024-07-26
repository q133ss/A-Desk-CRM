<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function update(array $data)
    {
        $user = Auth('sanctum')->user();
        $update = $user->update($data);
        return $user->load('avatar');
    }

    public function changeAvatar($avatar)
    {
        $check = Auth('sanctum')->user()->avatar;
        if($check != null)
        {
            $file = str_replace(env('APP_URL').'/storage/', '', $check->src);
            Storage::disk('public')->delete($file);
        }

        File::create([
            'fileable_type' => 'App\Models\User',
            'fileable_id' => Auth('sanctum')->id(),
            'category' => 'avatar',
            'src' => env('APP_URL').'/storage/'.$avatar->store('avatars', 'public')
        ]);

        return true;
    }

    public function passwordUpdate(string $password): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $user = Auth()->user();
        $update = $user->update(['password' => Hash::make($password)]);
        return $user;
    }
}
