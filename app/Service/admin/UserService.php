<?php

namespace App\Service\admin;
use App\Service\ServiceInterface;
use App\Repositories\admin\UserRepository;
use Exception;


class UserService implements ServiceInterface{

    public $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    /*
    //  @return void 
    */
    public function getAll(){
        return $this->userRepository->getAll();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return $this->userRepository->getOne($id);
    }

    public function paginate($num)
    {   
        return $this->userRepository->paginate($num);
    }

    public function create(){
        $user = auth()->user();
        $role = $user->roles;
        $permissions = empty($user->permissions) ? $role->permissions : $user->permissions;
    }

    public function store($data){
      return $this->userRepository->store($data);
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