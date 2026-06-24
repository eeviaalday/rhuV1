@extends('layouts.admin')
@section('title', 'Archive')
@section('header', 'Archived Patients')
@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Total Archived</div><div class="text-2xl font-bold text-gray-600">{{ $totalArchived }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Transferred</div><div class="text-2xl font-bold text-blue-600">{{ $transferred }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Deceased</div><div class="text-2xl font-bold text-red-600">{{ $deceased }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Inactive 2+ yrs</div><div class="text-2xl font-bold text-yellow-600">{{ $inactive2yrs }}</div></div>
</div>
<form method="GET" class="mb-4 flex flex-wrap gap-3">
    <input type="text" name="search" placeholder="Search name..." value="{{ request('search') }}" class="px-3 py-2 border rounded-lg">
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.archive.export' : 'user.archive.export') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Export CSV</a>
</form>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Name</th><th class="text-left py-3 px-4">Birthdate</th><th class="text-left py-3 px-4">Barangay</th><th class="text-left py-3 px-4">Reason</th><th class="text-left py-3 px-4">Archived Date</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>@forelse($patients as $p)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4">{{ $p->full_name }}</td>
                <td class="py-3 px-4">{{ $p->birthdate ? $p->birthdate->format('M d, Y') : 'N/A' }}</td>
                <td class="py-3 px-4">{{ $p->barangay }}</td>
                <td class="py-3 px-4">{{ $p->archived_reason ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $p->updated_at->format('M d, Y') }}</td>
                <td class="py-3 px-4">
                    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.archive.restore' : 'user.archive.restore', $p->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-green-600 hover:underline" onclick="return confirm('Restore this patient?')">Restore</button>
                    </form>
                </td>
            </tr>
        @empty<tr><td colspan="6" class="py-4 text-center text-gray-500">No archived patients</td></tr>@endforelse</tbody>
    </table>
    <div class="p-4">{{ $patients->links() }}</div>
</div>
@endsection
