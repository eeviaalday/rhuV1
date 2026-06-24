@extends('layouts.admin')
@section('title', 'Edit Immunization')
@section('header', 'Edit Immunization Record')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.update' : 'user.immunizations.update', $immunization->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
                <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                    @foreach($patients as $p)
                    <option value="{{ $p->id }}" {{ old('patient_id', $immunization->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Vaccine *</label>
                <select name="vaccine_name" class="w-full px-3 py-2 border rounded-lg" required>
                    @foreach($vaccines as $v)
                    <option value="{{ $v }}" {{ old('vaccine_name', $immunization->vaccine_name) == $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Dose Number</label><input type="number" name="dose_number" value="{{ old('dose_number', $immunization->dose_number) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Schedule Date</label><input type="date" name="schedule_date" value="{{ old('schedule_date', $immunization->schedule_date ? $immunization->schedule_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Date Given</label><input type="date" name="date_given" value="{{ old('date_given', $immunization->date_given ? $immunization->date_given->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Batch Number</label><input type="text" name="batch_number" value="{{ old('batch_number', $immunization->batch_number) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Expiry Date</label><input type="date" name="expiry_date" value="{{ old('expiry_date', $immunization->expiry_date ? $immunization->expiry_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Administered By</label><input type="text" name="administered_by" value="{{ old('administered_by', $immunization->administered_by) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Injection Site</label><select name="injection_site" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Left Arm" {{ old('injection_site', $immunization->injection_site) == 'Left Arm' ? 'selected' : '' }}>Left Arm</option><option value="Right Arm" {{ old('injection_site', $immunization->injection_site) == 'Right Arm' ? 'selected' : '' }}>Right Arm</option><option value="Left Thigh" {{ old('injection_site', $immunization->injection_site) == 'Left Thigh' ? 'selected' : '' }}>Left Thigh</option><option value="Right Thigh" {{ old('injection_site', $immunization->injection_site) == 'Right Thigh' ? 'selected' : '' }}>Right Thigh</option><option value="Oral" {{ old('injection_site', $immunization->injection_site) == 'Oral' ? 'selected' : '' }}>Oral</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Next Due Date</label><input type="date" name="next_due_date" value="{{ old('next_due_date', $immunization->next_due_date ? $immunization->next_due_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Remarks</label><textarea name="remarks" rows="2" class="w-full px-3 py-2 border rounded-lg">{{ old('remarks', $immunization->remarks) }}</textarea></div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.index' : 'user.immunizations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg">Update Record</button>
        </div>
    </form>
</div>
@endsection
