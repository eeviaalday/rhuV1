@extends('layouts.admin')
@section('title', 'M2 Report')
@section('header', 'M2 - Monthly Notifiable Disease Report')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" class="mb-4 flex gap-3 items-end">
        <div><label class="block text-gray-700 text-sm font-bold mb-2">Year</label><select name="year"><option value="">Select</option>@for($y = date('Y') - 5; $y <= date('Y'); $y++)<option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>@endfor</select></div>
        <div><label class="block text-gray-700 text-sm font-bold mb-2">Month</label><select name="month">@for($m = 1; $m <= 12; $m++)<option value="{{ $m }}" {{ ($month ?? date('m')) == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>@endfor</select></div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Generate</button>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.pdf' : 'user.fhsis.pdf', 'm2') }}?year={{ $year }}&month={{ $month }}" class="bg-red-600 text-white px-4 py-2 rounded-lg" target="_blank">Export PDF</a>
    </form>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="border px-3 py-2">Patient</th><th class="border px-3 py-2">Diagnosis</th><th class="border px-3 py-2">ICD-10</th><th class="border px-3 py-2">Severity</th><th class="border px-3 py-2">Outcome</th><th class="border px-3 py-2">Date Reported</th></tr></thead>
        <tbody>@forelse($records as $r)
            <tr class="border-t"><td class="border px-3 py-2">{{ $r->patient->full_name ?? 'N/A' }}</td><td class="border px-3 py-2">{{ $r->diagnosis }}</td><td class="border px-3 py-2">{{ $r->icd10_code ?? 'N/A' }}</td><td class="border px-3 py-2">{{ $r->severity ?? 'N/A' }}</td><td class="border px-3 py-2">{{ ucfirst($r->outcome ?? 'N/A') }}</td><td class="border px-3 py-2">{{ $r->created_at->format('M d, Y') }}</td></tr>
        @empty<tr><td colspan="6" class="border px-3 py-2 text-center text-gray-500">No notifiable disease records for this period.</td></tr>@endforelse</tbody>
    </table>
</div>
@endsection
