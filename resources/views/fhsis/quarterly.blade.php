@extends('layouts.admin')
@section('title', 'Quarterly Summary')
@section('header', 'Quarterly Summary')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" class="mb-4 flex gap-3 items-end">
        <div><label class="block text-gray-700 text-sm font-bold mb-2">Year</label><select name="year">@for($y = date('Y') - 5; $y <= date('Y'); $y++)<option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>@endfor</select></div>
        <div><label class="block text-gray-700 text-sm font-bold mb-2">Quarter</label><select name="quarter">@for($q = 1; $q <= 4; $q++)<option value="{{ $q }}" {{ ($quarter ?? date('Q')) == $q ? 'selected' : '' }}>Q{{ $q }}</option>@endfor</select></div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Generate</button>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.pdf' : 'user.fhsis.pdf', 'quarterly') }}?year={{ $year }}&quarter={{ $quarter }}" class="bg-red-600 text-white px-4 py-2 rounded-lg" target="_blank">Export PDF</a>
    </form>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg"><div class="text-lg font-bold">{{ $records->count() }}</div><div class="text-sm">Notifiable Diseases</div></div>
        <div class="bg-green-50 p-4 rounded-lg"><div class="text-lg font-bold">{{ $consultations }}</div><div class="text-sm">Total Consultations</div></div>
        <div class="bg-purple-50 p-4 rounded-lg"><div class="text-lg font-bold">{{ $records->where('outcome', 'recovered')->count() }}</div><div class="text-sm">Recovered</div></div>
    </div>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="border px-3 py-2">Patient</th><th class="border px-3 py-2">Diagnosis</th><th class="border px-3 py-2">Severity</th><th class="border px-3 py-2">Outcome</th></tr></thead>
        <tbody>@forelse($records as $r)
            <tr class="border-t"><td class="border px-3 py-2">{{ $r->patient->full_name ?? 'N/A' }}</td><td class="border px-3 py-2">{{ $r->diagnosis }}</td><td class="border px-3 py-2">{{ $r->severity ?? 'N/A' }}</td><td class="border px-3 py-2">{{ ucfirst($r->outcome ?? 'N/A') }}</td></tr>
        @empty<tr><td colspan="4" class="border px-3 py-2 text-center text-gray-500">No records for this quarter.</td></tr>@endforelse</tbody>
    </table>
</div>
@endsection
