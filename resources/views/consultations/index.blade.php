@extends('layouts.admin')
@section('title', 'Consultations')
@section('header', 'Consultations')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Today</div><div class="text-2xl font-bold text-blue-600">{{ $todayCount }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">This Month</div><div class="text-2xl font-bold text-green-600">{{ $monthlyCount }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Referred</div><div class="text-2xl font-bold text-orange-600">{{ $referredCount }}</div></div>
</div>
<form method="GET" class="mb-4 flex flex-col md:flex-row gap-3">
    <input type="text" name="search" placeholder="Search name or diagnosis..." value="{{ request('search') }}" class="px-3 py-2 border rounded-lg">
    <input type="date" name="date" value="{{ request('date') }}" class="px-3 py-2 border rounded-lg">
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Filter</button>
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.create' : 'user.consultations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-center">+ New Consultation</a>
</form>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Patient</th><th class="text-left py-3 px-4">BP</th><th class="text-left py-3 px-4">Diagnosis</th><th class="text-left py-3 px-4">Date</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>@forelse($consultations as $c)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $c->patient_id) }}" class="text-green-600 hover:underline">{{ $c->patient->full_name ?? 'N/A' }}</a></td>
                <td class="py-3 px-4">{{ $c->blood_pressure ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ Str::limit($c->diagnosis, 40) }}</td>
                <td class="py-3 px-4">{{ $c->date->format('M d, Y') }}</td>
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.consultations.show' : 'user.consultations.show', $c->id) }}" class="text-blue-600 hover:underline">View</a></td>
            </tr>
        @empty<tr><td colspan="5" class="py-4 text-center text-gray-500">No consultations found</td></tr>@endforelse</tbody>
    </table>
    <div class="p-4">{{ $consultations->links() }}</div>
</div>
@endsection
