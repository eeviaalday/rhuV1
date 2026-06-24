@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">Total Patients</div>
        <div class="text-3xl font-bold text-green-600">{{ $totalPatients }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">Active Patients</div>
        <div class="text-3xl font-bold text-blue-600">{{ $activePatients }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">Prenatal Cases</div>
        <div class="text-3xl font-bold text-purple-600">{{ $prenatalCases }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-500 text-sm">Today's Consultations</div>
        <div class="text-3xl font-bold text-orange-600">{{ $todayConsultations }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.consultations.create') }}" class="bg-blue-500 text-white text-center py-3 rounded-lg hover:bg-blue-600 transition">New Consultation</a>
            <a href="{{ route('admin.maternal.create') }}" class="bg-pink-500 text-white text-center py-3 rounded-lg hover:bg-pink-600 transition">Maternal Care</a>
            <a href="{{ route('admin.immunizations.create') }}" class="bg-purple-500 text-white text-center py-3 rounded-lg hover:bg-purple-600 transition">Immunization</a>
            <a href="{{ route('admin.fhsis.index') }}" class="bg-orange-500 text-white text-center py-3 rounded-lg hover:bg-orange-600 transition">FHSIS Reports</a>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Patients by Barangay</h3>
        <canvas id="barangayChart" height="150"></canvas>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-bold text-lg mb-4">Recent Patients</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">Name</th><th class="text-left py-2 px-3">Barangay</th><th class="text-left py-2 px-3">Sex</th><th class="text-left py-2 px-3">Created</th></tr></thead>
            <tbody>
                @forelse($recentPatients as $p)
                <tr class="border-t hover:bg-gray-50"><td class="py-2 px-3">{{ $p->full_name }}</td><td class="py-2 px-3">{{ $p->barangay }}</td><td class="py-2 px-3">{{ $p->sex }}</td><td class="py-2 px-3">{{ $p->created_at->format('M d, Y') }}</td></tr>
                @empty
                <tr><td colspan="4" class="py-4 text-center text-gray-500">No patients yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($patientsByBarangay->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('barangayChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($patientsByBarangay->pluck('barangay')) !!},
            datasets: [{
                label: 'Patients',
                data: {!! json_encode($patientsByBarangay->pluck('count')) !!},
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
});
</script>
@endif
@endsection
