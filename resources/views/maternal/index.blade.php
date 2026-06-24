@extends('layouts.admin')
@section('title', 'Maternal Care')
@section('header', 'Maternal Care')
@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">1st Trimester</div><div class="text-2xl font-bold text-pink-600">{{ $firstTrimester }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">2nd Trimester</div><div class="text-2xl font-bold text-purple-600">{{ $secondTrimester }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">3rd Trimester</div><div class="text-2xl font-bold text-blue-600">{{ $thirdTrimester }}</div></div>
    <div class="bg-white rounded-lg shadow p-4"><div class="text-gray-500 text-sm">Due This Week</div><div class="text-2xl font-bold text-orange-600">{{ $dueThisWeek }}</div></div>
</div>
<form method="GET" class="mb-4 flex gap-3">
    <input type="text" name="search" placeholder="Search patient name..." value="{{ request('search') }}" class="px-3 py-2 border rounded-lg">
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.create' : 'user.maternal.create') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">+ New Case</a>
</form>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50"><th class="text-left py-3 px-4">Patient</th><th class="text-left py-3 px-4">LMP</th><th class="text-left py-3 px-4">EDD</th><th class="text-left py-3 px-4">AOG</th><th class="text-left py-3 px-4">Trimester</th><th class="text-left py-3 px-4">Actions</th></tr></thead>
        <tbody>@forelse($cases as $case)
            @php 
                $weeks = $case->lmp ? $case->lmp->diffInWeeks(\Carbon\Carbon::now()) : 0;
                $tri = 'N/A';
                if ($case->lmp) { if($weeks <= 12) $tri='1st'; elseif($weeks <= 26) $tri='2nd'; else $tri='3rd'; }
            @endphp
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.show' : 'user.maternal.show', $case->id) }}" class="text-green-600 hover:underline">{{ $case->patient->full_name ?? 'N/A' }}</a></td>
                <td class="py-3 px-4">{{ $case->lmp ? $case->lmp->format('M d, Y') : 'N/A' }}</td>
                <td class="py-3 px-4">{{ $case->edd ? $case->edd->format('M d, Y') : 'N/A' }}</td>
                <td class="py-3 px-4">{{ $case->lmp ? $weeks . ' wks' : 'N/A' }}</td>
                <td class="py-3 px-4">{{ $tri }}</td>
                <td class="py-3 px-4"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.show' : 'user.maternal.show', $case->id) }}" class="text-blue-600 hover:underline">View</a></td>
            </tr>
        @empty<tr><td colspan="6" class="py-4 text-center text-gray-500">No maternal cases</td></tr>@endforelse</tbody>
    </table>
    <div class="p-4">{{ $cases->links() }}</div>
</div>
@endsection
