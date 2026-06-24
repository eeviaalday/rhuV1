@extends('layouts.admin')
@section('title', 'Prenatal Visit')
@section('header', 'Prenatal Visit - ' . $prenatalVisit->visit_date->format('M d, Y'))
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Prenatal Exam</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt>Date:</dt><dd>{{ $prenatalVisit->visit_date->format('M d, Y') }}</dd></div>
            <div class="flex justify-between"><dt>Weight:</dt><dd>{{ $prenatalVisit->weight ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>BP:</dt><dd>{{ $prenatalVisit->blood_pressure ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Fundal Height:</dt><dd>{{ $prenatalVisit->fundal_height ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>FHR:</dt><dd>{{ $prenatalVisit->fetal_heart_rate ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Fetal Movement:</dt><dd>{{ $prenatalVisit->fetal_movement ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>AOG:</dt><dd>{{ $prenatalVisit->age_of_gestation ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Presentation:</dt><dd>{{ $prenatalVisit->presentation ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Edema:</dt><dd>{{ $prenatalVisit->edema ?? 'N/A' }}</dd></div>
        </dl>
    </div>
    @if($prenatalVisit->antenatalCare)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Antenatal Care</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt>Tetanus Toxoid:</dt><dd>{{ $prenatalVisit->antenatalCare->tetanus_toxoid ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Anti-Helminthic:</dt><dd>{{ $prenatalVisit->antenatalCare->anti_helminthic ? 'Yes' : 'No' }}</dd></div>
            <div class="flex justify-between"><dt>Iron/Folate:</dt><dd>{{ $prenatalVisit->antenatalCare->iron_folate ? 'Yes' : 'No' }}</dd></div>
            <div class="flex justify-between"><dt>Counseling:</dt><dd>{{ $prenatalVisit->antenatalCare->counseling_done ? 'Yes' : 'No' }}</dd></div>
            <div class="flex justify-between"><dt>Next Schedule:</dt><dd>{{ $prenatalVisit->antenatalCare->next_schedule ? $prenatalVisit->antenatalCare->next_schedule->format('M d, Y') : 'N/A' }}</dd></div>
        </dl>
    </div>
    @endif
    @if($prenatalVisit->abdominalExam)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Abdominal Exam</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt>Trimester:</dt><dd>{{ $prenatalVisit->abdominalExam->trimester ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Fundic Height:</dt><dd>{{ $prenatalVisit->abdominalExam->fundic_height_cm ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>FHT:</dt><dd>{{ $prenatalVisit->abdominalExam->fetal_heart_tones ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Leopold's:</dt><dd>{{ $prenatalVisit->abdominalExam->leopolds_maneuver ?? 'N/A' }}</dd></div>
            <div class="flex justify-between"><dt>Uterine Activity:</dt><dd>{{ $prenatalVisit->abdominalExam->uterine_activity ?? 'N/A' }}</dd></div>
        </dl>
    </div>
    @endif
</div>
<div class="mt-4">
    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.show' : 'user.maternal.show', $maternalCase->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Back to Case</a>
</div>
@endsection
