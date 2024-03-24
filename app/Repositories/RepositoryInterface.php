<?php

namespace App\Repositories;

interface RepositoryInterface{

    public function getAll();

    public function getOne($id);

    public function paginate($num);

    public function create();

    public function store($data);

    public function edit($id);

    public function update($id, $data);

    public function destroy($id);


}