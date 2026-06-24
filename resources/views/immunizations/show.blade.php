@extends('layouts.admin')
@section('title', 'Immunization Record')
@section('header', 'Immunization Record')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <p><strong>Patient:</strong> <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $immunization->patient_id) }}" class="text-green-600 hover:underline">{{ $immunization->patient->full_name }}</a></p>
        <p><strong>Vaccine:</strong> {{ $immunization->vaccine_name }}</p>
        <p><strong>Dose:</strong> {{ $immunization->dose_number ?? 'N/A' }}</p>
        <p><strong>Schedule:</strong> {{ $immunization->schedule_date ? $immunization->schedule_date->format('M d, Y') : 'N/A' }}</p>
        <p><strong>Date Given:</strong> {{ $immunization->date_given ? $immunization->date_given->format('M d, Y') : 'Pending' }}</p>
        <p><strong>Batch:</strong> {{ $immunization->batch_number ?? 'N/A' }}</p>
        <p><strong>Expiry:</strong> {{ $immunization->expiry_date ? $immunization->expiry_date->format('M d, Y') : 'N/A' }}</p>
        <p><strong>Administered By:</strong> {{ $immunization->administered_by ?? 'N/A' }}</p>
        <p><strong>Injection Site:</strong> {{ $immunization->injection_site ?? 'N/A' }}</p>
        <p><strong>Next Due:</strong> {{ $immunization->next_due_date ? $immunization->next_due_date->format('M d, Y') : 'N/A' }}</p>
        <p class="md:col-span-2"><strong>Remarks:</strong> {{ $immunization->remarks ?? 'None' }}</p>
    </div>
    <div class="flex justify-end mt-6">
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.edit' : 'user.immunizations.edit', $immunization->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 mr-2">Edit</a>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.index' : 'user.immunizations.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Back</a>
    </div>
</div>
@endsection
