@extends('layouts.admin')
@section('title', 'Edit Patient')
@section('header', 'Edit Patient: ' . $patient->full_name)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.patients.update' : 'user.patients.update', $patient->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">First Name *</label><input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label><input type="text" name="middle_name" value="{{ old('middle_name', $patient->middle_name) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Birthdate *</label><input type="date" name="birthdate" value="{{ old('birthdate', $patient->birthdate ? $patient->birthdate->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Sex *</label><select name="sex" class="w-full px-3 py-2 border rounded-lg" required><option value="">Select</option><option value="Male" {{ old('sex', $patient->sex) == 'Male' ? 'selected' : '' }}>Male</option><option value="Female" {{ old('sex', $patient->sex) == 'Female' ? 'selected' : '' }}>Female</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Blood Type</label><select name="blood_type" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option>@foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)<option value="{{ $bt }}" {{ old('blood_type', $patient->blood_type) == $bt ? 'selected' : '' }}>{{ $bt }}</option>@endforeach</select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">PhilHealth No.</label><input type="text" name="philhealth_number" value="{{ old('philhealth_number', $patient->philhealth_number) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Religion</label><input type="text" name="religion" value="{{ old('religion', $patient->religion) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Ethnicity</label><input type="text" name="ethnicity" value="{{ old('ethnicity', $patient->ethnicity) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Barangay *</label><input type="text" name="barangay" value="{{ old('barangay', $patient->barangay) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Province</label><input type="text" name="province" value="{{ old('province', $patient->province) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number', $patient->contact_number) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">4Ps Member</label><select name="is_4ps" class="w-full px-3 py-2 border rounded-lg"><option value="0" {{ old('is_4ps', $patient->is_4ps) == '0' ? 'selected' : '' }}>No</option><option value="1" {{ old('is_4ps', $patient->is_4ps) == '1' ? 'selected' : '' }}>Yes</option></select></div>
        </div>
        <h3 class="font-bold text-gray-700 mb-3 mt-4">Emergency Contact</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Contact Person</label><input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label><input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number', $patient->emergency_contact_number) }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $patient->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Update Patient</button>
        </div>
    </form>
</div>
@endsection
