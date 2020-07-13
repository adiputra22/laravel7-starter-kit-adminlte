<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Repositories\UserRepository;
use App\Components\User\Repositories\RoleRepository;
use App\Components\User\Services\UserService;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;
    private $userService;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        UserService $userService
    )
    {
        $this->userRepository = $userRepository;

        $this->roleRepository = $roleRepository;

        $this->userService = $userService;

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->getListUsers($request->all());

        return view('user.index',[
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = $this->roleRepository->getAll();

        return view('user.create',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        try {
            $user = $this->userService->saveUserFromRequest($request->post());

            $request->session()->flash('message', 'You are success save data permission!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'alert-danger');

            return redirect()->route('admin.users.create');
        }
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        return view('user.edit',[
            'user' => $user
        ]);
    }

    public function update(Request $request, $userId)
    {
        try {
            $user = $this->userService->updateUserFromRequest($userId, $request->post());

            $request->session()->flash('message', 'You are success save data user!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'alert-danger');

            return redirect()->route('admin.users.edit',['userId', $userId]);
        }
    }

    public function show(Request $request, $userId)
    {
        try {
            $user = $this->userRepository->find($userId);

            if (!$user) {
                throw new \Exception('User not found', 404);
            }

            $currentUserRoles = $user->roles()->get();

            $roles = $this->roleRepository->getAll();

            return view('user.show',[
                'roles' => $roles,
                'user' => $user,
                'currentUserRoles' => $currentUserRoles
            ]);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'alert-danger');

            return redirect()->route('admin.users.index');
        }
    }
}
