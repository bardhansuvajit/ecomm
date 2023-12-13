<?php

namespace App\Interfaces;

interface OrderInterface {
    // place order
    public function create(array $data);

    // detail by id
    public function findById(int $id);

    // detail by id
    public function findByorderNo(string $order_no, int $userId);

    // list all
    public function listAll(string $keyword);

    // find by user id
    public function findByUserId(int $userId);

    // public function findById($id);

    // public function update(int $id, array $data);
    // public function delete(int $id);
}
