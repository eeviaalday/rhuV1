@extends('layouts.admin')
@section('title', 'New Immunization Record')
@section('header', 'New Immunization Record')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.store' : 'user.immunizations.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
                <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->full_name }} - {{ $p->barangay }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Vaccine *</label>
                <select name="vaccine_name" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Select Vaccine</option>
                    @foreach($vaccines as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Dose Number</label><input type="number" name="dose_number" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Schedule Date</label><input type="date" name="schedule_date" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Date Given</label><input type="date" name="date_given" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Batch Number</label><input type="text" name="batch_number" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Expiry Date</label><input type="date" name="expiry_date" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Administered By</label><input type="text" name="administered_by" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Injection Site</label>
                <select name="injection_site" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Select</option>
                    <option value="Left Arm">Left Arm</option>
                    <option value="Right Arm">Right Arm</option>
                    <option value="Left Thigh">Left Thigh</option>
                    <option value="Right Thigh">Right Thigh</option>
                    <option value="Oral">Oral</option>
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Next Due Date</label><input type="date" name="next_due_date" class="w-full px-3 py-2 border rounded-lg"></div>
            <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-bold mb-2">Remarks</label><textarea name="remarks" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.index' : 'user.immunizations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Save Record</button>
        </div>
    </form>
</div>
@endsection
