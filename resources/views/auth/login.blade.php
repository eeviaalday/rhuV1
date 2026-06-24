@extends('layouts.guest')
@section('title', 'Login')
@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500 @error('username') border-red-500 @enderror" required autofocus>
            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500 @error('password') border-red-500 @enderror" required>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-sm text-gray-600">Remember me</label>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Login</button>
    </form>
    <div class="mt-4 text-center text-sm">
        @if(isset($usersExist) && !$usersExist)
            <a href="{{ route('first.time.register') }}" class="text-green-600 hover:underline">First-time Setup (Admin Registration)</a>
        @endif
        <br>
        <a href="{{ route('password.forgot') }}" class="text-gray-600 hover:underline">Forgot Password?</a>
    </div>
</div>
@endsection
