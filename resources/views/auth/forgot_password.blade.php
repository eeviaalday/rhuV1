@extends('layouts.guest')
@section('title', 'Forgot Password')
@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Forgot Password</h2>
    <form method="POST" action="{{ route('password.forgot') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full px-3 py-2 border rounded-lg" required>
            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Verify Security Questions</button>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-green-600 hover:underline">Back to Login</a>
    </div>
</div>
@endsection
