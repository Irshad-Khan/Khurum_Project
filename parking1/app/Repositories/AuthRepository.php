<?php

namespace App\Repositories;

use App\Contracts\AuthInterface;
use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class AuthRepository implements AuthInterface
{
    use SendsPasswordResetEmails;

    public function signup($request)
    {
        return User::create(array_merge(
            $request->all(),
            ['password' => bcrypt($request->password)]
        ));
    }

    public function forgotPassword($request)
    {
        // Password::sendResetLink($request->only('email'));
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }
}
