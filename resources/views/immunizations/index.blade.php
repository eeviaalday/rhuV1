@extends('layouts.admin')
@section('title', 'Immunizations')
@section('header', 'Immunization Records')
@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Fully Vaccinated</div><div class="text-2xl font-bold text-green-600">{{ $fullyVaccinated }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Incomplete</div><div class="text-2xl font-bold text-yellow-600">{{ $incomplete }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Overdue</div><div class="text-2xl font-bold text-red-600">{{ $overdue }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Due This Week</div><div class="text-2xl font-bold text-blue-600">{{ $dueThisWeek }}</div></div>
</div>
<form method="GET" class="mb-4 flex flex-wrap gap-3">
    <input type="text" name="search" placeholder="Search patient..." value="{{ request('search') }}" class="px-3 py-2 border rounded-lg">
    <select name="barangay" class="px-3 py-2 border rounded-lg"><option value="">All Barangays</option>@foreach($barangays as $b)<option value="{{ $b }}" {{ request('barangay') == $b ? 'selected' : '' }}>{{ $b }}</option>@endforeach</select>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.create' : 'user.immunizations.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg">+ New Record</a>
</form>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Patient</th><th class="text-left py-3 px-4">Vaccine</th><th class="text-left py-3 px-4">Dose</th><th class="text-left py-3 px-4">Schedule</th><th class="text-left py-3 px-4">Date Given</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>@forelse($records as $r)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $r->patient_id) }}" class="text-green-600 hover:underline">{{ $r->patient->full_name ?? 'N/A' }}</a></td>
                <td class="py-3 px-4">{{ $r->vaccine_name }}</td>
                <td class="py-3 px-4">{{ $r->dose_number ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $r->schedule_date ? $r->schedule_date->format('M d, Y') : 'N/A' }}</td>
                <td class="py-3 px-4">{{ $r->date_given ? $r->date_given->format('M d, Y') : 'Pending' }}</td>
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.immunizations.show' : 'user.immunizations.show', $r->id) }}" class="text-blue-600 hover:underline">View</a></td>
            </tr>
        @empty<tr><td colspan="6" class="py-4 text-center text-gray-500">No immunization records</td></tr>@endforelse</tbody>
    </table>
    <div class="p-4">{{ $records->links() }}</div>
</div>
@endsection
