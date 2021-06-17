<?php

namespace App\Contracts;

interface AuthInterface
{
    public function signup($request);
    public function forgotPassword($request);
}