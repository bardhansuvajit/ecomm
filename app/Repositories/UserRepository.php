<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function listAll()
    {
        return User::orderBy('id', 'desc')->paginate(applicationSettings()->pagination_items_per_page);
    }

    public function listActive(string $sortBy = "id", string $orderBy = "desc")
    {
        return User::where('status', 1)->orderBy($sortBy, $orderBy)->get();
    }

    public function listInactive()
    {
        return User::where('status', 0)->orderBy('id', 'desc')->get();
    }

    public function findById($id) : array
    {
        // return User::findOrFail($id);

        $data = User::findOrFail($id);

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'User creation successfull',
                'data' => $data,
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'User does not exist',
            ];
            return $response;
        }

    }

    public function create(array $data) : array
    {
        $response = [];

        $user = new User();
        $user->first_name =$data['first_name'];
        $user->last_name = $data['last_name'];

        // email
        if ($data['email'] != $user->email) {
            $emailCheck = User::where('email', $data['email'])->first();

            if (!empty($emailCheck)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This email already exists',
                ];
                return $response;
            } else {
                $user->email = $data['email'];
            }
        }

        // mobile number
        if ($data['mobile_no'] != $user->mobile_no) {
            $mobileNoCheck = User::where('mobile_no', $data['mobile_no'])->first();

            if (!empty($mobileNoCheck)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This mobile number already exists',
                ];
                return $response;
            } else {
                $user->mobile_no = $data['mobile_no'];
            }
        }

        // whatsapp number
        if ($data['whatsapp_no'] != $user->whatsapp_no) {
            $whatsappNoCheck = User::where('whatsapp_no', $data['whatsapp_no'])->first();

            if (!empty($whatsappNoCheck)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This whatsapp number already exists',
                ];
                return $response;
            } else {
                $user->whatsapp_no = $data['whatsapp_no'];
            }
        }
        $user->password = Hash::make($data['password']);
        $user->gender = $data['gender'] ?? 'not specified';

        // new referral code generate
        $user->referral_code = mt_rand_custom(5);
        // if other referral used
        if (!empty($data['referral'])) {
            $referred_by = User::select('id')->where('referral_code', $data['referral'])->first();
            if (empty($referred_by)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'Invalid referral code',
                ];
                return $response;
            }

            $user->referred_by = $referred_by->id;
        } else {
            $user->referred_by = '';
        }
        $user->save();

        $response = [
            'status' => 'success',
            'message' => 'User creation successfull',
        ];
        return $response;
    }

    public function delete($id) : array
    {
        User::destroy($id);
        $response = [
            'status' => 'success',
            'message' => 'User details deleted',
        ];
        return $response;
    }

    public function update(array $data) : array
    {
        $response = [];

        $user = User::findOrFail($data['id']);
        $user->first_name =$data['first_name'];
        $user->last_name = $data['last_name'];

        if ($data['email'] != $user->email) {
            $emailCheck = User::where('email', $data['email'])->first();

            if (!empty($emailCheck)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This email already exists',
                ];
                return $response;
            } else {
                $user->email = $data['email'];
            }
        }

        if ($data['mobile_no'] != $user->mobile_no) {
            $mobileNoCheck = User::where('mobile_no', $data['mobile_no'])->first();

            if (!empty($mobileNoCheck)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This mobile number already exists',
                ];
                return $response;
            } else {
                $user->mobile_no = $data['mobile_no'];
            }
        }

        if ($data['whatsapp_no'] != $user->whatsapp_no) {
            $whatsappNoCheck = User::where('whatsapp_no', $data['whatsapp_no'])->first();

            if (!empty($whatsappNoCheck)) {
                $response = [
                    'status' => 'failure',
                    'message' => 'This whatsapp number already exists',
                ];
                return $response;
            } else {
                $user->whatsapp_no = $data['whatsapp_no'];
            }
        }

        $user->gender = $data['gender'] ?? 'not specified';
        $user->save();

        $response = [
            'status' => 'success',
            'message' => 'User detail updated',
        ];
        return $response;
    }

    public function resetPassword(array $data) : array
    {
        $response = [];

        $user = User::findOrFail($data['id']);
        $user->password = Hash::make($data['password']);
        $user->save();

        $response = [
            'status' => 'success',
            'message' => 'Password reset successfull',
        ];
        return $response;
    }
}
