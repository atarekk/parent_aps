<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $filter
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getAllUsers(Request $filter)
    {
        if ($filter->hasAny(["provider", "statusCode", "balanceMin", "balanceMax", "currency"])) {
            return $this->userService->filter($filter);
        }
        return $this->userService->getAllUsers();
    }
}
