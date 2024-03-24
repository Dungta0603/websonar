<?php

namespace App\Service\admin;
use App\Service\ServiceInterface;
use App\Repositories\admin\PermissionRepository;

class PermissionService implements ServiceInterface{
    public $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository){
        $this->permissionRepository = $permissionRepository;
    }
    /*
    //  @return void 
    */
    public function getAll(){
        return $this->permissionRepository->getAll();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return $this->permissionRepository->getOne($id);
    }

    public function paginate($num)
    {   
        return $this->permissionRepository->paginate($num);
    }

    public function create(){

    }

    public function store($data){
      return $this->permissionRepository->store($data);
    }

    public function edit($id)
    {
        
    }

    public function update($id, $data)
    {
        return $this->permissionRepository->update($id,$data);
    }
    
    public function destroy($id){
        return $this->permissionRepository->destroy($id);
    }   
}