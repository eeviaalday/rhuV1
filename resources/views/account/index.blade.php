@extends('layouts.admin')
@section('title', 'My Account')
@section('header', 'My Account')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">Profile Information</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-600">Name:</dt><dd>{{ $user->full_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Username:</dt><dd>{{ $user->username }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Sex:</dt><dd>{{ $user->sex ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Birthdate:</dt><dd>{{ $user->birthdate ? $user->birthdate->format('M d, Y') : 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Civil Status:</dt><dd>{{ $user->civil_status ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Blood Type:</dt><dd>{{ $user->blood_type ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Barangay:</dt><dd>{{ $user->barangay ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Contact:</dt><dd>{{ $user->contact_number ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">PhilHealth ID:</dt><dd>{{ $user->philhealth_id ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Role:</dt><dd><span class="px-2 py-1 rounded text-xs {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">{{ ucfirst($user->role) }}</span></dd></div>
            </dl>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Update Profile</h3>
            <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.account.update_profile' : 'user.account.update_profile') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update Profile</button>
            </form>
        </div>
    </div>
    <div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">Change Password</h3>
            <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.account.change_password' : 'user.account.change_password') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Change Password</button>
            </form>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Recent Activity</h3>
            @if($recentActivity->count())
            <ul class="space-y-2">
                @foreach($recentActivity as $log)
                <li class="text-sm border-b pb-2">
                    <span class="text-gray-500">{{ $log->created_at->format('M d, Y h:i A') }}</span><br>
                    <span class="text-gray-700">{{ $log->action }} - {{ $log->module }}</span>
                    @if($log->description)<p class="text-xs text-gray-500">{{ $log->description }}</p>@endif
                </li>
                @endforeach
            </ul>
            @else<p class="text-gray-500 text-sm">No recent activity.</p>@endif
        </div>
    </div>
</div>
@endsection
