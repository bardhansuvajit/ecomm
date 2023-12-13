<?php

namespace App\Interfaces;

interface AuthInterface {
    // login check
    public function check(array $data);

    // mobile number check
    public function checkMobile(int $number);

    // register
    public function create(array $data);

    // forgot password
    public function forgotPasswordEmailReset(string $email);

    // update user
    public function update(array $data, int $id);

    // verify old password
    public function verifyOldPassword(string $oldPassword, int $userId);

    // verify old & update new password
    public function updatePassword(string $newPassword, int $userId);
}
