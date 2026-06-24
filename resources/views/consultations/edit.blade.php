@extends('layouts.admin')
@section('title', 'Edit Consultation')
@section('header', 'Edit Consultation')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.update' : 'user.consultations.update', $consultation->id) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
            <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                @foreach($patients as $p)
                <option value="{{ $p->id }}" {{ old('patient_id', $consultation->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Date *</label><input type="date" name="date" value="{{ old('date', $consultation->date->format('Y-m-d')) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
        <h3 class="font-bold text-gray-700 mb-3">Vital Signs</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">BP</label><input type="text" name="blood_pressure" value="{{ old('blood_pressure', $consultation->blood_pressure) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Temp</label><input type="text" name="temperature" value="{{ old('temperature', $consultation->temperature) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">HR</label><input type="text" name="heart_rate" value="{{ old('heart_rate', $consultation->heart_rate) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">RR</label><input type="text" name="respiratory_rate" value="{{ old('respiratory_rate', $consultation->respiratory_rate) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">BMI</label><input type="text" name="bmi" value="{{ old('bmi', $consultation->bmi) }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <h3 class="font-bold text-gray-700 mb-3">Consultation Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Chief Complaint</label><textarea name="chief_complaint" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('chief_complaint', $consultation->chief_complaint) }}</textarea></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Findings</label><textarea name="findings" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('findings', $consultation->findings) }}</textarea></div>
        </div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Diagnosis</label><textarea name="diagnosis" rows="2" class="w-full px-3 py-2 border rounded-lg">{{ old('diagnosis', $consultation->diagnosis) }}</textarea></div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Prescription</label><textarea name="prescription" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('prescription', $consultation->prescription) }}</textarea></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Outcome</label><select name="outcome" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Improved" {{ old('outcome', $consultation->outcome) == 'Improved' ? 'selected' : '' }}>Improved</option><option value="Unchanged" {{ old('outcome', $consultation->outcome) == 'Unchanged' ? 'selected' : '' }}>Unchanged</option><option value="Worsened" {{ old('outcome', $consultation->outcome) == 'Worsened' ? 'selected' : '' }}>Worsened</option><option value="Recovered" {{ old('outcome', $consultation->outcome) == 'Recovered' ? 'selected' : '' }}>Recovered</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Referral?</label><select name="is_referral" class="w-full px-3 py-2 border rounded-lg"><option value="0" {{ old('is_referral', $consultation->is_referral) == '0' ? 'selected' : '' }}>No</option><option value="1" {{ old('is_referral', $consultation->is_referral) == '1' ? 'selected' : '' }}>Yes</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Notifiable?</label><select name="is_notifiable" class="w-full px-3 py-2 border rounded-lg"><option value="0" {{ old('is_notifiable', $consultation->is_notifiable) == '0' ? 'selected' : '' }}>No</option><option value="1" {{ old('is_notifiable', $consultation->is_notifiable) == '1' ? 'selected' : '' }}>Yes</option></select></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.index' : 'user.consultations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg">Update Consultation</button>
        </div>
    </form>
</div>
@endsection
