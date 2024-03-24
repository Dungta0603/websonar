<?php

namespace App\Repositories\admin;
use App\Repositories\RepositoryInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRepository implements RepositoryInterface{

    public function getAll(){
        return Permission::all();
    }

    public function getOne($id){
        return Permission::find($id);
    }

    public function paginate($num){
        return Permission::paginate($num);
    }

    public function create(){

    }

    public function store($data){
        $permission = Permission::create(['name' => $data['permission']]);
        if(!(empty($data['role']))){
            $permission->assignRole($data['role']);
        }
    }

    public function edit($id){

    }

    public function update($id, $data){
        $permission = Permission::findOrFail($id);
        $permission->name = $data['permission'];
        $permission->save();
        $permission->syncRoles($data['role']);
    }

    public function destroy($id){
        $permission = Permission::find($id);
        foreach ($permission->roles as $role){
        $permission->removeRole($role);
        }
        $permission->delete();

    }

}
