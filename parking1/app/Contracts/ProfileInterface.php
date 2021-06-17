<?php

namespace App\Contracts;

interface ProfileInterface
{
    public function get();
    public function update($request, $id);
}