<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\AuthInterface;
use App\Interfaces\CartInterface;

use App\Models\User;

class AuthRepository implements AuthInterface
{
    private CartInterface $cartRepository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function check(array $data) : array
    {
        // dd($data);

        $response = [];

        if (auth()->guard('web')->attempt(['mobile_no' => $data['mobile_no'], 'password' => $data['password']], true)) {
            if (auth()->guard('web')->user()->status == 1) {
                // check if product exists in cookie
                if (!empty($_COOKIE['_cart-token'])) {
                    $token = $_COOKIE['_cart-token'];

                    // cart update
                    $resp = $this->cartRepository->update($token);
                }

                $response = [
                    'status' => 'success',
                    'message' => 'Login successfull',
                    'redirect' => $data['redirect'] ?? ''
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'Your account is blocked. Contact support',
                ];
                return $response;
            }
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Invalid credential',
            ];
            return $response;
        }
    }

    public function checkMobile(int $number) : array
    {
        $response = [];

        $userCheck = User::where('mobile_no', $number)->first();

        if (!empty($userCheck)) {
            if ($userCheck->status == 1) {
                $response = [
                    'status' => 'success',
                    'message' => 'Account found. Enter password to login',
                    'type' => 'login'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'Your account is blocked. Try different mobile number',
                    'type' => 'login-blocked'
                ];
                return $response;
            }
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No user found. Register with this mobile number',
                'type' => 'register'
            ];
            return $response;
        }
    }

    public function create(array $data) : array
    {
        $response = [];

        try {
            $user = new User();
            if (isset($data['name'])) {
                $full_name = explode(' ', $data['name']);
                $user->first_name = $full_name[0] ?? '';
                $user->last_name = $full_name[1] ?? '';
            } else {
                $user->first_name = $data['first_name'] ?? '';
                $user->last_name = $data['last_name'] ?? '';
            }

            $user->email = $data['email'] ?? '';
            $user->mobile_no = $data['phone'];
            $user->whatsapp_no = $data['whatsapp_no'] ?? '';
            $user->password = Hash::make($data['password']);
            
            if(!empty($data['gender'])) {
                $user->gender = $data['gender'];
            } else {
                $user->gender = 'not specified';
            }

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

            // $creds = $request->only([$user->email, $user->password]);
            $resp = $this->check(['mobile_no' => $data['phone'], 'password' => $data['password']]);

            if ($resp['status'] == 'success') {
                $response = [
                    'status' => 'success',
                    'message' => $resp['message'],
                    'redirect' => $data['redirect'] ?? ''
                ];
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => $resp['message'],
                ];
            }
            return $response;
        } catch (\Throwable $th) {
            // dd('here dd');
            // throw $th;

            $response = [
                'status' => 'failure',
                'message' => 'Something happened',
            ];
            return $response;
        }
    }

    public function forgotPasswordEmailReset(string $email) : array
    {
        $randomToken = mt_rand_custom(4);

        // 1. change password
        $user_passwordUpdate = User::where('email', $email)->update([
            'password' => Hash::make($randomToken),
            'default_password_set' => 1
        ]);

        $email_data = [
            'type' => 'forgot-password',
            'target_name' => '',
            'target_email' => $email,
        ];

        $mailSend = SendMail($email_data);

        // if($mailSend) {
            $response = [
                'status' => 'success',
                'message' => 'Password reset successfull. Please check email'
            ];
        // } else {
        //     $response = [
        //         'status' => 'failure',
        //         'message' => 'Something happened. Try again later'
        //     ];
        // }

        // $email_data = [
        //     'name' => $full_name,
        //     'subject' => 'Onn - New registration',
        //     'email' => $collectedData['email'],
        //     'password' => $password,
        //     'blade_file' => 'front/mail/register',
        // ];
        // SendMail($email_data);
    }

    public function update(array $data, int $id) : array
    {
        $user = User::findOrFail($id);

        if ($user) {
            if(!empty($data['first_name'])) {
                $user->first_name = $data['first_name'];
            }
            if(!empty($data['last_name'])) {
                $user->last_name = $data['last_name'];
            }
            if(!empty($data['email'])) {
                if ($user->email != $data['email']) {
                    // check for other users with the email address
                    $checkUserEmail = User::where('email', $data['email'])->first();

                    if (!empty($checkUserEmail)) {
                        $response = [
                            'status' => 'failure',
                            'message' => 'This email address is already taken',
                            'type' => 'err'
                        ];
                        return $response;
                    } else {
                        $user->email = $data['email'];
                    }
                }
            }
            if(!empty($data['mobile_no'])) {
                if ($user->mobile_no != $data['mobile_no']) {
                    // check for other users with the mobile number
                    $checkUserMobileNo = User::where('mobile_no', $data['mobile_no'])->first();

                    if (!empty($checkUserMobileNo)) {
                        $response = [
                            'status' => 'failure',
                            'message' => 'This mobile number is already taken',
                            'type' => 'err'
                        ];
                        return $response;
                    } else {
                        $user->mobile_no = $data['mobile_no'];
                    }
                }
            }
            if(!empty($data['gender'])) {
                $user->gender = $data['gender'];
            }
            $user->save();

            $response = [
                'status' => 'success',
                'message' => 'Information updated'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
            return $response;
        }
    }

    public function verifyOldPassword(string $oldPassword, int $userId) : array
    {
        $user = User::findOrFail($userId);

        if ($user) {
            if (Hash::check($oldPassword, $user->password)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Enter new password'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'Password does not match. Enter valid password'
                ];
                return $response;
            }
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
            return $response;
        }
    }

    public function updatePassword(string $newPassword, int $userId)
    {
        $user = User::findOrFail($userId);

        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->save();

            $response = [
                'status' => 'success',
                'message' => 'Password updated'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
            return $response;
        }
    }
}
