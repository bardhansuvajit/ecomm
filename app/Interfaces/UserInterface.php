<?php

namespace App\Interfaces;

interface UserInterface {
    public function listAll();
    public function listActive();
    public function listInactive();

    public function findById($id);

    public function create(array $data);
    public function delete(int $id);
    public function update(array $data);
    public function resetPassword(array $data);
}
