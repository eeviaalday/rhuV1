@extends('layouts.admin')
@section('title', 'FHSIS Reports')
@section('header', 'FHSIS Reports')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="font-bold text-lg mb-2">M1 - Monthly Health Statistics</h3>
        <p class="text-gray-600 text-sm mb-4">Family planning, deworming stats</p>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.m1' : 'user.fhsis.m1') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Generate Report</a>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="font-bold text-lg mb-2">M2 - Notifiable Disease Report</h3>
        <p class="text-gray-600 text-sm mb-4">Monthly notifiable disease records</p>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.m2' : 'user.fhsis.m2') }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Generate Report</a>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="font-bold text-lg mb-2">Quarterly Summary</h3>
        <p class="text-gray-600 text-sm mb-4">Quarterly morbidity summary</p>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.quarterly' : 'user.fhsis.quarterly') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Generate Report</a>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="font-bold text-lg mb-2">Annual Summary</h3>
        <p class="text-gray-600 text-sm mb-4">Annual statistics and summaries</p>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.annual' : 'user.fhsis.annual') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Generate Report</a>
    </div>
</div>
@endsection
