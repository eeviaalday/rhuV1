@extends('layouts.admin')
@section('title', 'Morbidity')
@section('header', 'Morbidity Records')
@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Total</div><div class="text-2xl font-bold text-blue-600">{{ $total }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Notifiable</div><div class="text-2xl font-bold text-red-600">{{ $notifiable }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Recovered</div><div class="text-2xl font-bold text-green-600">{{ $recovered }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Deceased</div><div class="text-2xl font-bold text-gray-600">{{ $deceased }}</div></div>
</div>
<form method="GET" class="mb-4 flex flex-wrap gap-3">
    <input type="text" name="search" placeholder="Search diagnosis/ICD-10..." value="{{ request('search') }}" class="px-3 py-2 border rounded-lg">
    <input type="month" name="month" value="{{ request('month') }}" class="px-3 py-2 border rounded-lg">
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.create' : 'user.morbidity.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg">+ New Record</a>
</form>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Patient</th><th class="text-left py-3 px-4">Diagnosis</th><th class="text-left py-3 px-4">ICD-10</th><th class="text-left py-3 px-4">Severity</th><th class="text-left py-3 px-4">Notifiable</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>@forelse($records as $r)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $r->patient_id) }}" class="text-green-600 hover:underline">{{ $r->patient->full_name ?? 'N/A' }}</a></td>
                <td class="py-3 px-4">{{ Str::limit($r->diagnosis, 40) }}</td>
                <td class="py-3 px-4">{{ $r->icd10_code ?? 'N/A' }}</td>
                <td class="py-3 px-4"><span class="px-2 py-1 rounded text-xs {{ $r->severity == 'Severe' ? 'bg-red-100 text-red-800' : ($r->severity == 'Moderate' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">{{ $r->severity ?? 'N/A' }}</span></td>
                <td class="py-3 px-4">{{ $r->is_notifiable ? 'Yes' : 'No' }}</td>
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.morbidity.show' : 'user.morbidity.show', $r->id) }}" class="text-blue-600 hover:underline">View</a></td>
            </tr>
        @empty<tr><td colspan="6" class="py-4 text-center text-gray-500">No morbidity records</td></tr>@endforelse</tbody>
    </table>
    <div class="p-4">{{ $records->links() }}</div>
</div>
@endsection
