<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('facility')->orderBy('last_name')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
            'designation' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'designation' => $request->designation,
            'contact_number' => $request->contact_number,
            'is_active' => true,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'user_management',
            'record_id' => $user->id,
            'description' => 'Created user: ' . $user->full_name,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'designation' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['first_name', 'middle_name', 'last_name', 'username', 'designation', 'contact_number']));

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'user_management',
            'record_id' => $user->id,
            'description' => 'Updated user: ' . $user->full_name,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'admin_password' => 'required|string',
        ]);

        if (!Hash::check($request->admin_password, auth()->user()->password)) {
            return back()->withErrors(['admin_password' => 'Your password is incorrect.']);
        }

        $tempPassword = 'temp_' . substr(md5(uniqid()), 0, 8);
        $user->update([
            'password' => Hash::make($tempPassword),
            'last_password_change' => null,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'reset_password',
            'module' => 'user_management',
            'record_id' => $user->id,
            'description' => 'Reset password for user: ' . $user->full_name,
        ]);

        return back()->with('success', "Password reset successful. Temporary password: {$tempPassword}");
    }
}
