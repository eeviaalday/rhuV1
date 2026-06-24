@extends('layouts.guest')
@section('title', 'First Time Setup')
@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-2 text-center">First-Time Setup</h2>
    <p class="text-gray-600 text-center mb-6">Create the facility and admin account</p>
    <form method="POST" action="{{ route('first.time.register') }}">
        @csrf
        <h3 class="font-bold text-green-700 mb-3">Facility Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Facility Name</label>
                <input type="text" name="facility_name" value="{{ old('facility_name') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">RHU Code</label>
                <input type="text" name="rhu_code" value="{{ old('rhu_code') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500" required>
            </div>
        </div>
        <h3 class="font-bold text-green-700 mb-3">Admin Account</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
        </div>
        <h3 class="font-bold text-green-700 mb-3">Security Questions</h3>
        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Question 1</label>
                <input type="text" name="question1" value="{{ old('question1') }}" class="w-full px-3 py-2 border rounded-lg" required>
                <label class="block text-gray-700 text-sm font-bold mb-2 mt-2">Answer 1</label>
                <input type="text" name="answer1" value="{{ old('answer1') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Question 2</label>
                <input type="text" name="question2" value="{{ old('question2') }}" class="w-full px-3 py-2 border rounded-lg" required>
                <label class="block text-gray-700 text-sm font-bold mb-2 mt-2">Answer 2</label>
                <input type="text" name="answer2" value="{{ old('answer2') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Question 3</label>
                <input type="text" name="question3" value="{{ old('question3') }}" class="w-full px-3 py-2 border rounded-lg" required>
                <label class="block text-gray-700 text-sm font-bold mb-2 mt-2">Answer 3</label>
                <input type="text" name="answer3" value="{{ old('answer3') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Create Account & Setup Facility</button>
    </form>
</div>
@endsection
