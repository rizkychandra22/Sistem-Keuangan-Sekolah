<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ControllerUser extends Controller
{
    public function index()
    {
        $users = User::query()->orderBy('created_at', 'asc')->get();

        if (request()->ajax()) {
            return datatables()->of($users)->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('dataUser.index');
        $currentTitle = 'Akun User';
        $createLink = route('dataUser.create');
        $createTitle = 'Create';

        return view('admin.user.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        $roleOptions = $this->creatableRoles();

        // Route dan nama halaman yang di akses
        $currentLink = route('dataUser.index');
        $currentTitle = 'Akun User';
        $createLink = route('dataUser.create');
        $createTitle = 'Create';

        return view('admin.user.create', compact('roleOptions', 'currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => ['required', Rule::in($this->creatableRoles())],
        ], [
            'name.required' => 'Nama akun user harus diisi',
            'username.required' => 'Username akun user harus diisi',
            'username.unique' => 'Username akun user sudah digunakan',
            'email.required' => 'Email akun user harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email akun user sudah digunakan',
            'role.required' => 'Role akun user harus dipilih',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make('sekolah'),
        ]);

        return redirect()->route('dataUser.index')->with('success', 'Akun user ' . $validated['username'] . ' berhasil ditambahkan dengan password default sekolah.');
    }

    public function edit(User $user)
    {
        $isRoleLocked = $this->isRoleLocked($user);
        $roleOptions = $isRoleLocked ? [$user->role] : $this->creatableRoles();

        // Route dan nama halaman yang di akses
        $currentLink = route('dataUser.index');
        $currentTitle = 'Akun User';
        $editLink = route('dataUser.edit', $user->id);
        $editTitle = 'Edit';

        return view('admin.user.edit', compact('user', 'isRoleLocked', 'roleOptions', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, User $user)
    {
        $isRoleLocked = $this->isRoleLocked($user);
        $allowedRoles = $isRoleLocked ? [$user->role] : $this->creatableRoles();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in($allowedRoles)],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama akun user harus diisi',
            'username.required' => 'Username akun user harus diisi',
            'username.unique' => 'Username akun user sudah digunakan',
            'email.required' => 'Email akun user harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email akun user sudah digunakan',
            'role.required' => 'Role akun user harus dipilih',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $payload = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $isRoleLocked ? $user->role : $validated['role'],
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $user->update($payload);

        return redirect()->route('dataUser.index')->with('success', 'Akun user ' . $user->username . ' berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json([
                'message' => 'Akun yang sedang digunakan login tidak bisa dihapus.',
            ], 422);
        }

        if (in_array($user->role, $this->protectedRoles(), true)) {
            return response()->json([
                'message' => 'Akun user dengan role ' . $user->role . ' tidak boleh dihapus.',
            ], 422);
        }

        $username = $user->username;
        $user->delete();

        return response()->json([
            'message' => 'Akun user ' . $username . ' berhasil dihapus.',
        ]);
    }

    private function creatableRoles(): array
    {
        return ['guru', 'siswa'];
    }

    private function protectedRoles(): array
    {
        return ['admin', 'operator', 'keuangan'];
    }

    private function isRoleLocked(User $user): bool
    {
        return in_array($user->role, $this->protectedRoles(), true);
    }
}
