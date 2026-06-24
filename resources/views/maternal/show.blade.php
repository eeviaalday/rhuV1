@extends('layouts.admin')
@section('title', 'Maternal Case')
@section('header', 'Maternal Case - ' . $maternalCase->patient->full_name)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Case Summary</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-600">LMP:</dt><dd>{{ $maternalCase->lmp ? $maternalCase->lmp->format('M d, Y') : 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">EDD:</dt><dd>{{ $maternalCase->edd ? $maternalCase->edd->format('M d, Y') : 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">AOG:</dt><dd>{{ $aog }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Trimester:</dt><dd>{{ $trimester }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Gravida:</dt><dd>{{ $maternalCase->gravida ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Parity:</dt><dd>{{ $maternalCase->parity ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Living Children:</dt><dd>{{ $maternalCase->living_children ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Supplements:</dt><dd>{{ $maternalCase->supplements_issued ?? 'None' }}</dd></div>
            </dl>
            <div class="mt-4">
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.visits.create' : 'user.maternal.visits.create', $maternalCase->id) }}" class="block text-center bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700">+ Add Prenatal Visit</a>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Prenatal Visit History</h3>
            @if($maternalCase->prenatalVisits->count())
            <table class="w-full text-sm">
                <thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">Date</th><th class="text-left py-2 px-3">Weight</th><th class="text-left py-2 px-3">BP</th><th class="text-left py-2 px-3">FH</th><th class="text-left py-2 px-3">FHR</th><th class="text-left py-2 px-3">AOG</th><th class="text-left py-2 px-3">Actions</th></tr></thead>
                <tbody>@foreach($maternalCase->prenatalVisits as $v)
                    <tr class="border-t">
                        <td class="py-2 px-3">{{ $v->visit_date->format('M d, Y') }}</td>
                        <td class="py-2 px-3">{{ $v->weight ?? 'N/A' }}</td>
                        <td class="py-2 px-3">{{ $v->blood_pressure ?? 'N/A' }}</td>
                        <td class="py-2 px-3">{{ $v->fundal_height ?? 'N/A' }}</td>
                        <td class="py-2 px-3">{{ $v->fetal_heart_rate ?? 'N/A' }}</td>
                        <td class="py-2 px-3">{{ $v->age_of_gestation ?? 'N/A' }}</td>
                        <td class="py-2 px-3"><a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.visits.show' : 'user.maternal.visits.show', [$maternalCase->id, $v->id]) }}" class="text-blue-600 hover:underline">View</a></td>
                    </tr>
                @endforeach</tbody>
            </table>
            @else<p class="text-gray-500">No prenatal visits yet.</p>@endif
        </div>
    </div>
</div>
@endsection
