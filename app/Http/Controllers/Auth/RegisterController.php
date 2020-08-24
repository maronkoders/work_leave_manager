<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

    protected function create(array $data)
    {
        $generateUserPassword = $this->generateRandomString();
        return User::create([
            'email' => $data['email'],
            'name' => ucfirst($data['name']),
            'surname' => ucfirst($data['surname']),
            'positionId' => $data['positionId'],
            'departmentId' => $data['departmentId'],
            'subDepartmentId' => $data['subDepartmentId'],
            'gradeId' => $data['gradeId'],
            'roleId' => $data['roleId'],
            'userName' => $generateUserPassword,
            'password' => bcrypt($generateUserPassword),
        ]);
    }

    public function generateRandomString()
    {
        $alphabet =
            'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function notification($email)
    {
        $notification = [
            'message' =>
                'new user was added, and logg in details send to ' . $email,
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
