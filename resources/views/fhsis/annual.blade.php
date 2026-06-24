@extends('layouts.admin')
@section('title', 'Annual Summary')
@section('header', 'Annual Summary - ' . $year)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" class="mb-4 flex gap-3 items-end">
        <div><label class="block text-gray-700 text-sm font-bold mb-2">Year</label><select name="year">@for($y = date('Y') - 5; $y <= date('Y'); $y++)<option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>@endfor</select></div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Generate</button>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.pdf' : 'user.fhsis.pdf', 'annual') }}?year={{ $year }}" class="bg-red-600 text-white px-4 py-2 rounded-lg" target="_blank">Export PDF</a>
    </form>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg"><div class="text-2xl font-bold">{{ $records->count() }}</div><div class="text-sm">Morbidity Cases</div></div>
        <div class="bg-green-50 p-4 rounded-lg"><div class="text-2xl font-bold">{{ $consultations }}</div><div class="text-sm">Consultations</div></div>
        <div class="bg-pink-50 p-4 rounded-lg"><div class="text-2xl font-bold">{{ $maternalCases }}</div><div class="text-sm">Maternal Cases</div></div>
        <div class="bg-purple-50 p-4 rounded-lg"><div class="text-2xl font-bold">{{ $immunizations }}</div><div class="text-sm">Immunizations</div></div>
    </div>
    <h3 class="font-bold text-lg mb-4">Annual Morbidity Summary</h3>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="border px-3 py-2">Month</th><th class="border px-3 py-2">Total Cases</th><th class="border px-3 py-2">Notifiable</th><th class="border px-3 py-2">Recovered</th><th class="border px-3 py-2">Deceased</th></tr></thead>
        <tbody>@foreach(range(1,12) as $m)
            @php $monthRecords = $records->filter(function($r) use ($m) { return $r->created_at->month == $m; }); @endphp
            <tr class="border-t"><td class="border px-3 py-2">{{ date('F', mktime(0,0,0,$m,1)) }}</td>
                <td class="border px-3 py-2">{{ $monthRecords->count() }}</td>
                <td class="border px-3 py-2">{{ $monthRecords->where('is_notifiable', true)->count() }}</td>
                <td class="border px-3 py-2">{{ $monthRecords->where('outcome', 'recovered')->count() }}</td>
                <td class="border px-3 py-2">{{ $monthRecords->where('outcome', 'deceased')->count() }}</td>
            </tr>
        @endforeach</tbody>
    </table>
</div>
@endsection
