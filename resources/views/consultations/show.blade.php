@extends('layouts.admin')
@section('title', 'Consultation')
@section('header', 'Consultation Details')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-bold text-lg mb-3">Patient Information</h3>
            <p><strong>Name:</strong> <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $consultation->patient_id) }}" class="text-green-600 hover:underline">{{ $consultation->patient->full_name ?? 'N/A' }}</a></p>
            <p><strong>Date:</strong> {{ $consultation->date->format('F d, Y') }}</p>
            <p><strong>Seen by:</strong> {{ $consultation->user->full_name ?? 'N/A' }}</p>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-3">Vital Signs</h3>
            <div class="grid grid-cols-2 gap-2">
                <p><strong>BP:</strong> {{ $consultation->blood_pressure ?? 'N/A' }}</p>
                <p><strong>Temp:</strong> {{ $consultation->temperature ?? 'N/A' }}</p>
                <p><strong>HR:</strong> {{ $consultation->heart_rate ?? 'N/A' }}</p>
                <p><strong>RR:</strong> {{ $consultation->respiratory_rate ?? 'N/A' }}</p>
                <p><strong>BMI:</strong> {{ $consultation->bmi ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div><h4 class="font-bold mb-2">Chief Complaint</h4><p class="text-gray-700">{{ $consultation->chief_complaint ?? 'None' }}</p></div>
        <div><h4 class="font-bold mb-2">Findings</h4><p class="text-gray-700">{{ $consultation->findings ?? 'None' }}</p></div>
    </div>
    <hr class="my-4">
    <div class="mb-4"><h4 class="font-bold mb-2">Diagnosis</h4><p class="text-gray-700">{{ $consultation->diagnosis ?? 'None' }}</p></div>
    <div class="mb-4"><h4 class="font-bold mb-2">Prescription / Treatment</h4><p class="text-gray-700">{{ $consultation->prescription ?? 'None' }}</p></div>
    <hr class="my-4">
    <div class="grid grid-cols-3 gap-4">
        <p><strong>Outcome:</strong> {{ $consultation->outcome ?? 'N/A' }}</p>
        <p><strong>Referral:</strong> {{ $consultation->is_referral ? 'Yes' : 'No' }}</p>
        <p><strong>Notifiable:</strong> {{ $consultation->is_notifiable ? 'Yes' : 'No' }}</p>
    </div>
    <div class="flex justify-end mt-6 space-x-3">
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.print' : 'user.consultations.print', $consultation->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600" target="_blank">Print</a>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.index' : 'user.consultations.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Back</a>
    </div>
</div>
@endsection
