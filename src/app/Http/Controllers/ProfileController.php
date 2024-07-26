<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileController\GeneralRequest;
use App\Http\Requests\ProfileController\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function general(GeneralRequest $request)
    {
        return (new ProfileService())->update($request->validated());
    }

    public function profile(ProfileRequest $request)
    {
        $data = $request->validated();
        (new ProfileService())->changeAvatar($data['avatar']);
        unset($data['avatar']);

        return (new ProfileService())->update($data);
    }
}
