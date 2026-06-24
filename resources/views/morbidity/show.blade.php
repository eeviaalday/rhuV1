@extends('layouts.admin')
@section('title', 'Morbidity Record')
@section('header', 'Morbidity Record Details')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    @if($morbidity->is_notifiable)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">This is a NOTIFIABLE disease. DOH reporting required.</div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <p><strong>Patient:</strong> <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $morbidity->patient_id) }}" class="text-green-600 hover:underline">{{ $morbidity->patient->full_name }}</a></p>
        <p><strong>Diagnosis:</strong> {{ $morbidity->diagnosis }}</p>
        <p><strong>ICD-10 Code:</strong> {{ $morbidity->icd10_code ?? 'N/A' }}</p>
        <p><strong>Category:</strong> {{ $morbidity->disease_category ?? 'N/A' }}</p>
        <p><strong>Severity:</strong> {{ $morbidity->severity ?? 'N/A' }}</p>
        <p><strong>Notifiable:</strong> {{ $morbidity->is_notifiable ? 'Yes' : 'No' }}</p>
        <p><strong>Outcome:</strong> {{ ucfirst($morbidity->outcome ?? 'N/A') }}</p>
        <p><strong>DOH Submitted:</strong> {{ $morbidity->doh_submitted_at ? $morbidity->doh_submitted_at->format('M d, Y h:i A') : 'Not submitted' }}</p>
        <p><strong>Locked:</strong> {{ $morbidity->locked_at ? $morbidity->locked_at->format('M d, Y h:i A') : 'No' }}</p>
    </div>
    <hr class="my-4">
    <h4 class="font-bold mb-2">Audit Trail</h4>
    <p class="text-sm text-gray-600">Created: {{ $morbidity->created_at->format('M d, Y h:i A') }}</p>
    <p class="text-sm text-gray-600">Last Updated: {{ $morbidity->updated_at->format('M d, Y h:i A') }}</p>
    <div class="flex justify-end mt-6">
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.edit' : 'user.morbidity.edit', $morbidity->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 mr-2">Edit</a>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.index' : 'user.morbidity.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Back</a>
    </div>
</div>
@endsection
