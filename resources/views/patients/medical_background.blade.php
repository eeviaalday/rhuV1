@extends('layouts.admin')
@section('title', 'Medical Background')
@section('header', 'Step 2: Medical Background - ' . $patient->full_name)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.patients.medical_background' : 'user.patients.medical_background', $patient->id) }}">
        @csrf
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Allergies</label>
                <textarea name="allergies" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('allergies', $background->allergies ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Medical Conditions</label>
                <textarea name="medical_conditions" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('medical_conditions', $background->medical_conditions ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Current Medications</label>
                <textarea name="medications" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('medications', $background->medications ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Surgical History</label>
                <textarea name="surgical_history" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('surgical_history', $background->surgical_history ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Family History</label>
                <textarea name="family_history" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('family_history', $background->family_history ?? '') }}</textarea>
            </div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.index' : 'user.patients.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Skip</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Save Medical Background</button>
        </div>
    </form>
</div>
@endsection
