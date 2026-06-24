@extends('layouts.admin')
@section('title', 'M1 Report')
@section('header', 'M1 - Monthly Health Statistics')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" class="mb-4 flex gap-3 items-end">
        <div><label class="block text-gray-700 text-sm font-bold mb-2">Year</label><select name="year" class="px-3 py-2 border rounded-lg">@for($y = date('Y') - 5; $y <= date('Y'); $y++)<option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>@endfor</select></div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Generate</button>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.pdf' : 'user.fhsis.pdf', 'm1') }}?year={{ $year }}" class="bg-red-600 text-white px-4 py-2 rounded-lg" target="_blank">Export PDF</a>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.fhsis.print' : 'user.fhsis.print') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg" target="_blank">Print</a>
    </form>
    <h3 class="font-bold text-lg mb-4">Family Planning Data by Age Group</h3>
    <table class="w-full text-sm mb-6">
        <thead><tr class="bg-gray-50"><th class="border px-3 py-2">Age Group</th><th class="border px-3 py-2">Pills</th><th class="border px-3 py-2">Injectables</th><th class="border px-3 py-2">Implants</th><th class="border px-3 py-2">IUD</th><th class="border px-3 py-2">Condoms</th><th class="border px-3 py-2">Sterilization</th></tr></thead>
        <tbody>@foreach($familyPlanning as $group => $data)
            <tr class="border-t"><td class="border px-3 py-2">{{ $group }}</td>
                @foreach($data as $val)<td class="border px-3 py-2">{{ $val }}</td>@endforeach
            </tr>
        @endforeach</tbody>
    </table>
    <h3 class="font-bold text-lg mb-4">Deworming Statistics</h3>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="border px-3 py-2">Category</th><th class="border px-3 py-2">Count</th></tr></thead>
        <tbody>
            <tr class="border-t"><td class="border px-3 py-2">Children (0-5 yrs)</td><td class="border px-3 py-2">{{ $dewormingStats['children'] }}</td></tr>
            <tr class="border-t"><td class="border px-3 py-2">Adults</td><td class="border px-3 py-2">{{ $dewormingStats['adults'] }}</td></tr>
        </tbody>
    </table>
</div>
@endsection
