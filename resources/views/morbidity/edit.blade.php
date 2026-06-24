@extends('layouts.admin')
@section('title', 'Edit Morbidity Record')
@section('header', 'Edit Morbidity Record')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.update' : 'user.morbidity.update', $morbidity->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
                <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                    @foreach($patients as $p)
                    <option value="{{ $p->id }}" {{ old('patient_id', $morbidity->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Diagnosis *</label><input type="text" name="diagnosis" value="{{ old('diagnosis', $morbidity->diagnosis) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">ICD-10 Code</label><input type="text" name="icd10_code" value="{{ old('icd10_code', $morbidity->icd10_code) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Category</label><select name="disease_category" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Infectious" {{ old('disease_category', $morbidity->disease_category) == 'Infectious' ? 'selected' : '' }}>Infectious</option><option value="Non-Communicable" {{ old('disease_category', $morbidity->disease_category) == 'Non-Communicable' ? 'selected' : '' }}>Non-Communicable</option><option value="Maternal" {{ old('disease_category', $morbidity->disease_category) == 'Maternal' ? 'selected' : '' }}>Maternal</option><option value="Neonatal" {{ old('disease_category', $morbidity->disease_category) == 'Neonatal' ? 'selected' : '' }}>Neonatal</option><option value="Nutritional" {{ old('disease_category', $morbidity->disease_category) == 'Nutritional' ? 'selected' : '' }}>Nutritional</option><option value="Injury" {{ old('disease_category', $morbidity->disease_category) == 'Injury' ? 'selected' : '' }}>Injury</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Severity</label><select name="severity" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Mild" {{ old('severity', $morbidity->severity) == 'Mild' ? 'selected' : '' }}>Mild</option><option value="Moderate" {{ old('severity', $morbidity->severity) == 'Moderate' ? 'selected' : '' }}>Moderate</option><option value="Severe" {{ old('severity', $morbidity->severity) == 'Severe' ? 'selected' : '' }}>Severe</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Notifiable?</label><select name="is_notifiable" class="w-full px-3 py-2 border rounded-lg"><option value="0" {{ old('is_notifiable', $morbidity->is_notifiable) == '0' ? 'selected' : '' }}>No</option><option value="1" {{ old('is_notifiable', $morbidity->is_notifiable) == '1' ? 'selected' : '' }}>Yes</option></select></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Outcome</label><select name="outcome" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="recovered" {{ old('outcome', $morbidity->outcome) == 'recovered' ? 'selected' : '' }}>Recovered</option><option value="referred" {{ old('outcome', $morbidity->outcome) == 'referred' ? 'selected' : '' }}>Referred</option><option value="deceased" {{ old('outcome', $morbidity->outcome) == 'deceased' ? 'selected' : '' }}>Deceased</option></select></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.index' : 'user.morbidity.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg">Update Record</button>
        </div>
    </form>
</div>
@endsection
