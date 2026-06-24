@extends('layouts.admin')
@section('title', $patient->full_name)
@section('header', 'Patient Record: ' . $patient->full_name)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Personal Information</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-600">Name:</dt><dd>{{ $patient->full_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Birthdate:</dt><dd>{{ $patient->birthdate ? $patient->birthdate->format('M d, Y') : 'N/A' }} ({{ $patient->age }} yrs)</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Sex:</dt><dd>{{ $patient->sex }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Blood Type:</dt><dd>{{ $patient->blood_type ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">PhilHealth:</dt><dd>{{ $patient->philhealth_number ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Religion:</dt><dd>{{ $patient->religion ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Ethnicity:</dt><dd>{{ $patient->ethnicity ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">4Ps:</dt><dd>{{ $patient->is_4ps ? 'Yes' : 'No' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Barangay:</dt><dd>{{ $patient->barangay }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Province:</dt><dd>{{ $patient->province ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Contact:</dt><dd>{{ $patient->contact_number ?? 'N/A' }}</dd></div>
            </dl>
            <hr class="my-4">
            <h4 class="font-bold mb-2">Emergency Contact</h4>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-600">Name:</dt><dd>{{ $patient->emergency_contact_name ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Contact:</dt><dd>{{ $patient->emergency_contact_number ?? 'N/A' }}</dd></div>
            </dl>
            <div class="mt-4 space-y-2">
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.edit' : 'user.patients.edit', $patient->id) }}" class="block text-center bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600">Edit</a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.create' : 'user.consultations.create') }}?patient_id={{ $patient->id }}" class="block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">New Consultation</a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.print' : 'user.patients.print', $patient->id) }}" class="block text-center bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600" target="_blank">Print</a>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div x-data="{ tab: 'consultations' }" class="bg-white rounded-lg shadow">
            <div class="border-b flex">
                <button @click="tab = 'consultations'" :class="{ 'border-b-2 border-green-500 text-green-600': tab === 'consultations' }" class="px-4 py-3 text-sm font-medium">Consultations</button>
                <button @click="tab = 'morbidity'" :class="{ 'border-b-2 border-green-500 text-green-600': tab === 'morbidity' }" class="px-4 py-3 text-sm font-medium">Morbidity</button>
                <button @click="tab = 'prenatal'" :class="{ 'border-b-2 border-green-500 text-green-600': tab === 'prenatal' }" class="px-4 py-3 text-sm font-medium">Prenatal</button>
                <button @click="tab = 'immunizations'" :class="{ 'border-b-2 border-green-500 text-green-600': tab === 'immunizations' }" class="px-4 py-3 text-sm font-medium">Immunizations</button>
            </div>
            <div class="p-4">
                <div x-show="tab === 'consultations'">
                    <h4 class="font-bold mb-3">Consultation History</h4>
                    @if($patient->consultations->count())
                    <table class="w-full text-sm"><thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">Date</th><th class="text-left py-2 px-3">BP</th><th class="text-left py-2 px-3">Diagnosis</th><th class="text-left py-2 px-3">Actions</th></tr></thead><tbody>@foreach($patient->consultations as $c)<tr class="border-t"><td class="py-2 px-3">{{ $c->date->format('M d, Y') }}</td><td class="py-2 px-3">{{ $c->blood_pressure ?? 'N/A' }}</td><td class="py-2 px-3">{{ Str::limit($c->diagnosis, 40) }}</td><td class="py-2 px-3"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.show' : 'user.consultations.show', $c->id) }}" class="text-blue-600 hover:underline">View</a></td></tr>@endforeach</tbody></table>
                    @else<p class="text-gray-500">No consultations recorded.</p>@endif
                </div>
                <div x-show="tab === 'morbidity'">
                    <h4 class="font-bold mb-3">Morbidity Records</h4>
                    @if($patient->morbidityRecords->count())
                    <table class="w-full text-sm"><thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">Diagnosis</th><th class="text-left py-2 px-3">ICD-10</th><th class="text-left py-2 px-3">Severity</th><th class="text-left py-2 px-3">Outcome</th></tr></thead><tbody>@foreach($patient->morbidityRecords as $m)<tr class="border-t"><td class="py-2 px-3">{{ $m->diagnosis }}</td><td class="py-2 px-3">{{ $m->icd10_code ?? 'N/A' }}</td><td class="py-2 px-3">{{ $m->severity ?? 'N/A' }}</td><td class="py-2 px-3">{{ ucfirst($m->outcome ?? 'N/A') }}</td></tr>@endforeach</tbody></table>
                    @else<p class="text-gray-500">No morbidity records.</p>@endif
                </div>
                <div x-show="tab === 'prenatal'">
                    <h4 class="font-bold mb-3">Prenatal Cases</h4>
                    @if($patient->maternalCases->count())
                    <table class="w-full text-sm"><thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">LMP</th><th class="text-left py-2 px-3">EDD</th><th class="text-left py-2 px-3">Gravida</th><th class="text-left py-2 px-3">Parity</th></tr></thead><tbody>@foreach($patient->maternalCases as $mc)<tr class="border-t"><td class="py-2 px-3">{{ $mc->lmp ? $mc->lmp->format('M d, Y') : 'N/A' }}</td><td class="py-2 px-3">{{ $mc->edd ? $mc->edd->format('M d, Y') : 'N/A' }}</td><td class="py-2 px-3">{{ $mc->gravida ?? 'N/A' }}</td><td class="py-2 px-3">{{ $mc->parity ?? 'N/A' }}</td></tr>@endforeach</tbody></table>
                    @else<p class="text-gray-500">No prenatal cases.</p>@endif
                </div>
                <div x-show="tab === 'immunizations'">
                    <h4 class="font-bold mb-3">Immunization Records</h4>
                    @if($patient->immunizationRecords->count())
                    <table class="w-full text-sm"><thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">Vaccine</th><th class="text-left py-2 px-3">Dose</th><th class="text-left py-2 px-3">Date Given</th><th class="text-left py-2 px-3">Next Due</th></tr></thead><tbody>@foreach($patient->immunizationRecords as $i)<tr class="border-t"><td class="py-2 px-3">{{ $i->vaccine_name }}</td><td class="py-2 px-3">{{ $i->dose_number ?? 'N/A' }}</td><td class="py-2 px-3">{{ $i->date_given ? $i->date_given->format('M d, Y') : 'Pending' }}</td><td class="py-2 px-3">{{ $i->next_due_date ? $i->next_due_date->format('M d, Y') : 'N/A' }}</td></tr>@endforeach</tbody></table>
                    @else<p class="text-gray-500">No immunization records.</p>@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
