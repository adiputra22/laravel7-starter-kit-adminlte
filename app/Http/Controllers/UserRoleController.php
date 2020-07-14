<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Services\UserService;

class UserRoleController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;

        $this->middleware('auth');
    }

    public function update(Request $request, $userId)
    {
        try {
            $user = $this->userService->userUpdateRoles($userId, $request->post('role'));

            $request->session()->flash('message', 'You are success save data user!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.users.show',['userId' => $userId]);
        } catch (\Exception $e) {

            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'alert-danger');

            return redirect()->route('admin.users.show',['userId' => $userId]);
        }
    }
}
