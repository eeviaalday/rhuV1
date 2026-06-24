@extends('layouts.admin')
@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">Total Patients</div>
        <div class="text-3xl font-bold text-green-600">{{ $totalPatients }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">Today's Consultations</div>
        <div class="text-3xl font-bold text-blue-600">{{ $todayConsultations }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">My Consultations</div>
        <div class="text-3xl font-bold text-purple-600">{{ $myConsultations }}</div>
    </div>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
    <a href="{{ route('user.consultations.create') }}" class="bg-blue-500 text-white text-center py-3 rounded-lg hover:bg-blue-600 transition">New Consultation</a>
    <a href="{{ route('user.maternal.create') }}" class="bg-pink-500 text-white text-center py-3 rounded-lg hover:bg-pink-600 transition">Maternal Care</a>
    <a href="{{ route('user.immunizations.create') }}" class="bg-purple-500 text-white text-center py-3 rounded-lg hover:bg-purple-600 transition">Immunization</a>
    <a href="{{ route('user.fhsis.index') }}" class="bg-orange-500 text-white text-center py-3 rounded-lg hover:bg-orange-600 transition">FHSIS Reports</a>
</div>
@endsection
