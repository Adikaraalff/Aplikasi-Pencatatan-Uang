<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'permission:user-list|user-create|user-edit|user-delete',
            ['only' => ['index', 'show']]
        );
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validateUser($request);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $this->validateUser($request, $user->id);

        $input = $request->all();

        if (empty($input['password'])) {
            $input = Arr::except($input, ['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        $user->update($input);

        $user->roles()->sync([$request->input('roles')]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    private function validateUser(Request $request, $userId = null)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $userId ? 'nullable' : 'required|same:confirm-password',
            'roles' => 'required',
        ];

        $this->validate($request, $rules);
    }
}
