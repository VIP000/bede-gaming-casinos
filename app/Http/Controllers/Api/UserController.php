<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->user();

        return array_merge($user->toArray(), [
            "is_admin" => $user->isAdmin(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        // @TODO
    }
}
