<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $recentActivity = AuditLog::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();
        return view('account.index', compact('user', 'recentActivity'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'contact_number' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($request->only(['contact_number']));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'last_password_change' => Carbon::now(),
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'change_password',
            'module' => 'account',
            'description' => 'User changed their password',
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
