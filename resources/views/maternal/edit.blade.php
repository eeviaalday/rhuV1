@extends('layouts.admin')
@section('title', 'Edit Maternal Case')
@section('header', 'Edit Maternal Case')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.update' : 'user.maternal.update', $maternalCase->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
                <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                    @foreach($patients as $p)
                    <option value="{{ $p->id }}" {{ old('patient_id', $maternalCase->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">LMP</label><input type="date" name="lmp" value="{{ old('lmp', $maternalCase->lmp ? $maternalCase->lmp->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">EDD</label><input type="date" name="edd" value="{{ old('edd', $maternalCase->edd ? $maternalCase->edd->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Gravida</label><input type="number" name="gravida" value="{{ old('gravida', $maternalCase->gravida) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Parity</label><input type="number" name="parity" value="{{ old('parity', $maternalCase->parity) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Living Children</label><input type="number" name="living_children" value="{{ old('living_children', $maternalCase->living_children) }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div class="md:col-span-3"><label class="block text-gray-700 text-sm font-bold mb-2">Supplements Issued</label><input type="text" name="supplements_issued" value="{{ old('supplements_issued', $maternalCase->supplements_issued) }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.index' : 'user.maternal.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg">Update Case</button>
        </div>
    </form>
</div>
@endsection
