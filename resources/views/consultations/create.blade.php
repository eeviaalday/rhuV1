@extends('layouts.admin')
@section('title', 'New Consultation')
@section('header', 'New Consultation')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.store' : 'user.consultations.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
            <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="">Select Patient</option>
                @foreach($patients as $p)
                <option value="{{ $p->id }}" {{ request('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->full_name }} - {{ $p->barangay }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Date *</label><input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
        <h3 class="font-bold text-gray-700 mb-3">Vital Signs</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Blood Pressure</label><input type="text" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="120/80" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Temperature</label><input type="text" name="temperature" value="{{ old('temperature') }}" placeholder="36.5" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Heart Rate</label><input type="text" name="heart_rate" value="{{ old('heart_rate') }}" placeholder="72" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Respiratory Rate</label><input type="text" name="respiratory_rate" value="{{ old('respiratory_rate') }}" placeholder="16" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">BMI</label><input type="text" name="bmi" value="{{ old('bmi') }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <h3 class="font-bold text-gray-700 mb-3">Consultation Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Chief Complaint</label><textarea name="chief_complaint" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('chief_complaint') }}</textarea></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Findings</label><textarea name="findings" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('findings') }}</textarea></div>
        </div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Diagnosis</label><textarea name="diagnosis" rows="2" class="w-full px-3 py-2 border rounded-lg">{{ old('diagnosis') }}</textarea></div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Prescription / Treatment</label><textarea name="prescription" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('prescription') }}</textarea></div>
        <h3 class="font-bold text-gray-700 mb-3">Outcome & Referral</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Outcome</label><select name="outcome" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Improved">Improved</option><option value="Unchanged">Unchanged</option><option value="Worsened">Worsened</option><option value="Recovered">Recovered</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Is Referral?</label><select name="is_referral" class="w-full px-3 py-2 border rounded-lg"><option value="0">No</option><option value="1">Yes</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Notifiable Disease?</label><select name="is_notifiable" class="w-full px-3 py-2 border rounded-lg"><option value="0">No</option><option value="1">Yes</option></select></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.index' : 'user.consultations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Save Consultation</button>
        </div>
    </form>
</div>
@endsection
