<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProfileInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use ApiResponseTrait;
    protected $profileInterface;

    public function __construct(ProfileInterface $profileInterface)
    {
        $this->profileInterface = $profileInterface;
    }

    public function get()
    {
        return $this->responseWithSuccess(true,'User Created Successfully!',
        (new UserResource($this->profileInterface->get())), Response::HTTP_OK);    
    }

    public function update(ProfileRequest $request, $id)
    {
        return $this->responseWithSuccess(true,'User Created Successfully!',
        (new UserResource($this->profileInterface->update($request, $id))), Response::HTTP_OK);
    }
}
