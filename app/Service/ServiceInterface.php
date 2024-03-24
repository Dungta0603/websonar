<?php

namespace App\Service;

interface ServiceInterface{

    public function getAll();

    public function getOne($id);

    public function paginate($num);

    public function create();

    public function store($data);

    public function edit($id);

    public function update($id, $data);

    public function destroy($id);
}