<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Repositories\UserRepository;
use App\Components\User\Repositories\RoleRepository;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    )
    {
        $this->userRepository = $userRepository;
        
        $this->roleRepository = $roleRepository;

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

    public function update(Request $request)
    {
        
    }

    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        $deleted = $this->userRepository->delete($user->id);

        if (!$deleted) {
            throw new \Exception('Failed delete', 404);
        }
    }
}
