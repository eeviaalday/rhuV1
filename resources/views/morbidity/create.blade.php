@extends('layouts.admin')
@section('title', 'New Morbidity Record')
@section('header', 'New Morbidity Record')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.store' : 'user.morbidity.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
                <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Search & Select Patient</option>
                    @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->full_name }} - {{ $p->barangay }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Diagnosis *</label><input type="text" name="diagnosis" value="{{ old('diagnosis') }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">ICD-10 Code</label><input type="text" name="icd10_code" value="{{ old('icd10_code') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Disease Category</label>
                <select name="disease_category" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Select</option>
                    <option value="Infectious">Infectious</option>
                    <option value="Non-Communicable">Non-Communicable</option>
                    <option value="Maternal">Maternal</option>
                    <option value="Neonatal">Neonatal</option>
                    <option value="Nutritional">Nutritional</option>
                    <option value="Injury">Injury</option>
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Severity</label>
                <select name="severity" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Select</option>
                    <option value="Mild">Mild</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Severe">Severe</option>
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Notifiable?</label>
                <select name="is_notifiable" class="w-full px-3 py-2 border rounded-lg">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Outcome</label>
                <select name="outcome" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Select</option>
                    <option value="recovered">Recovered</option>
                    <option value="referred">Referred</option>
                    <option value="deceased">Deceased</option>
                </select>
            </div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.index' : 'user.morbidity.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Save Record</button>
        </div>
    </form>
</div>
@endsection
