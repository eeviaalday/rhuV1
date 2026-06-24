<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Facility;
use App\Models\SecurityQuestion;
use App\Models\AuditLog;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        $usersExist = User::count() > 0;
        return view('auth.login', compact('usersExist'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        $user = User::where('username', $request->username)->first();

        if ($user && !$user->is_active) {
            return back()->withErrors(['username' => 'Account is deactivated.'])->withInput();
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            $user->update(['last_login' => Carbon::now()]);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'module' => 'auth',
                'description' => 'User logged in',
            ]);

            if ($user->last_password_change === null) {
                return redirect()->route('password.change.form')->with('warning', 'You must change your password on first login.');
            }

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors(['username' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'module' => 'auth',
                'description' => 'User logged out',
            ]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showFirstTimeRegister()
    {
        if (User::count() > 0) {
            return redirect()->route('login');
        }
        return view('auth.first_time_register');
    }

    public function firstTimeRegister(Request $request)
    {
        if (User::count() > 0) {
            return redirect()->route('login');
        }

        $request->validate([
            'facility_name' => 'required|string|max:255',
            'rhu_code' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'question1' => 'required|string',
            'answer1' => 'required|string',
            'question2' => 'required|string',
            'answer2' => 'required|string',
            'question3' => 'required|string',
            'answer3' => 'required|string',
        ]);

        $facility = Facility::create([
            'name' => $request->facility_name,
            'rhu_code' => $request->rhu_code,
            'location' => $request->location,
        ]);

        $user = User::create([
            'facility_id' => $facility->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_active' => true,
            'last_password_change' => Carbon::now(),
        ]);

        SecurityQuestion::create(['user_id' => $user->id, 'question' => $request->question1, 'answer_hash' => Hash::make(strtolower($request->answer1))]);
        SecurityQuestion::create(['user_id' => $user->id, 'question' => $request->question2, 'answer_hash' => Hash::make(strtolower($request->answer2))]);
        SecurityQuestion::create(['user_id' => $user->id, 'question' => $request->question3, 'answer_hash' => Hash::make(strtolower($request->answer3))]);

        Auth::login($user);
        return redirect()->route('admin.dashboard')->with('success', 'Facility and admin account created successfully.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['username' => 'required|exists:users,username']);
        $user = User::where('username', $request->username)->first();
        $questions = SecurityQuestion::where('user_id', $user->id)->get();
        
        if ($questions->count() < 3) {
            return back()->withErrors(['username' => 'No security questions set for this account.']);
        }

        session(['password_reset_user_id' => $user->id]);
        return redirect()->route('password.verify.questions');
    }

    public function showVerifyQuestions()
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('login');
        }
        $questions = SecurityQuestion::where('user_id', session('password_reset_user_id'))->get();
        return view('auth.verify_questions', compact('questions'));
    }

    public function verifyQuestions(Request $request)
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
        ]);

        $questions = SecurityQuestion::where('user_id', session('password_reset_user_id'))->orderBy('id')->get();

        $answers = [$request->answer1, $request->answer2, $request->answer3];
        $valid = true;

        foreach ($questions as $i => $question) {
            if (!isset($answers[$i]) || !Hash::check(strtolower($answers[$i]), $question->answer_hash)) {
                $valid = false;
                break;
            }
        }

        if (!$valid) {
            return back()->withErrors(['answer1' => 'One or more answers are incorrect.']);
        }

        session(['password_reset_verified' => true]);
        return redirect()->route('password.reset.form');
    }

    public function showResetPasswordForm()
    {
        if (!session('password_reset_user_id') || !session('password_reset_verified')) {
            return redirect()->route('login');
        }
        return view('auth.reset_password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('password_reset_user_id') || !session('password_reset_verified')) {
            return redirect()->route('login');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail(session('password_reset_user_id'));
        $user->update([
            'password' => Hash::make($request->password),
            'last_password_change' => Carbon::now(),
        ]);

        session()->forget(['password_reset_user_id', 'password_reset_verified']);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login.');
    }

    public function showPasswordChangeForm()
    {
        return view('auth.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'last_password_change' => Carbon::now(),
        ]);

        return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'user.dashboard')
            ->with('success', 'Password changed successfully.');
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
}
