<?php

namespace App\Services;

use App\Http\Requests\UserController\StoreRequest;
use App\Http\Requests\UserController\UpdateRequest;
use App\Mail\WellcomeUserMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{
    public function store(StoreRequest $request)
    {
        // Создаем юзера
        // Затем отправляем приглашение на почту
        // Если в течении недели он не вошел в систему, то удаляем его! (art check:invite)

        $password = Str::random(8);

        $role = Role::findOrFail($request->role_id);

        DB::beginTransaction();

        $user = User::create([
            'email' => $request->email,
            'name' => explode('@', $request->email)[0],
            'password' => Hash::make($password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'logged_in' => false
        ]);

        $permissions = [];

        if($role->id != Role::where('slug', 'custom')->pluck('id')->first()){
            foreach ($role->permissions as $permission){
                $permissions[] = $permission;
            }
        }else{
            foreach ($request->permissions as $permission){
                $permissions[] = $permission;
            }
        }

        DB::table('user_to_users')->insert([
            'owner_id' => Auth('sanctum')->id(),
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'permissions' => json_encode($permissions)
        ]);

        Mail::to($request->email)->queue(new WellcomeUserMail($user));

        DB::commit();

        return Response()->json([
            'message' => 'true'
        ]);
    }

    public function activate($user_id, $hash)
    {
        $user = User::findOrFail($user_id);
        if($user->logged_in == true || $user->hash != $hash){
            abort(403, 'Ошибка');
        }

        $user->logged_in = true;
        $user->save();

        $token = $user->createToken('web');
        return Response()->json(['user' => $user, 'token' => $token->plainTextToken]);
    }

    private function checkUser($id)
    {
        $user = User::findOrFail($id);
        $check = Auth('sanctum')->user()->users()->where('user_id', $user->id)->exists();
        if(!$check){
            abort(403, 'Указан неверный пользователь');
        }
        return $user;
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->checkUser($id);
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = $this->checkUser($id);
        $update = $user->update($request->validated());
        return Response()->json([
            'message' => 'true',
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $user = $this->checkUser($id);
        $user->delete();
        return Response()->json([
            'message' => 'true'
        ]);
    }
}
