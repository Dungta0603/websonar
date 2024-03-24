<?php

namespace App\Repositories\admin;
use App\Repositories\RepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRepository implements RepositoryInterface{

    /*
    //  @return void
    */
    public function getAll(){
        return User::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return User::find($id);
    }

    public function paginate($num)
    {
        return User::paginate($num);
    }

    public function create(){

    }

    public function store($data){
        try {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => 2,
            ]);
            event(new Registered($user));
            Auth::login($user);

            return $user->id;
        }catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {

    }

    public function update($id, $data)
    {

    }

    public function destroy($id){

    }
}

