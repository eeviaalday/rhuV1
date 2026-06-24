@extends('layouts.admin')
@section('title', 'Patients')
@section('header', 'Patient Records')
@section('content')
<div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <input type="text" name="search" placeholder="Search by name or PhilHealth..." value="{{ request('search') }}" class="px-3 py-2 border rounded-lg">
        <select name="barangay" class="px-3 py-2 border rounded-lg">
            <option value="">All Barangays</option>
            @foreach($barangays as $b)
            <option value="{{ $b }}" {{ request('barangay') == $b ? 'selected' : '' }}>{{ $b }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Filter</button>
    </form>
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.create' : 'user.patients.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-center">+ New Patient</a>
</div>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Name</th><th class="text-left py-3 px-4">Birthdate</th><th class="text-left py-3 px-4">Blood Type</th><th class="text-left py-3 px-4">PhilHealth No.</th><th class="text-left py-3 px-4">Barangay</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>
            @forelse($patients as $patient)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $patient->id) }}" class="text-green-600 hover:underline">{{ $patient->full_name }}</a></td>
                <td class="py-3 px-4">{{ $patient->birthdate ? $patient->birthdate->format('M d, Y') : 'N/A' }}</td>
                <td class="py-3 px-4">{{ $patient->blood_type ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $patient->philhealth_number ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $patient->barangay }}</td>
                <td class="py-3 px-4">
                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $patient->id) }}" class="text-blue-600 hover:underline mr-2">View</a>
                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.edit' : 'user.patients.edit', $patient->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-4 text-center text-gray-500">No patients found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $patients->links() }}</div>
</div>
@endsection
