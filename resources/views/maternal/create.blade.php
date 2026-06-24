@extends('layouts.admin')
@section('title', 'New Maternal Case')
@section('header', 'New Maternal Case Registration')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.store' : 'user.maternal.store') }}">
        @csrf
        <h3 class="font-bold text-gray-700 mb-3">Menstrual History</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Patient *</label>
                <select name="patient_id" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Select Female Patient</option>
                    @foreach($patients as $p)
                    <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->full_name }} - {{ $p->barangay }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">LMP</label><input type="date" name="lmp" value="{{ old('lmp') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">EDD</label><input type="date" name="edd" value="{{ old('edd') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Gravida</label><input type="number" name="gravida" value="{{ old('gravida') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Parity</label><input type="number" name="parity" value="{{ old('parity') }}" class="w-full px-3 py-2 border rounded-lg"></div>
            <div><label class="block text-gray-700 text-sm font-bold mb-2">Living Children</label><input type="number" name="living_children" value="{{ old('living_children') }}" class="w-full px-3 py-2 border rounded-lg"></div>
        </div>
        <h3 class="font-bold text-gray-700 mb-3">Physical Examination</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <label class="flex items-center"><input type="checkbox" name="supplements_issued" value="Iron" class="mr-2"> Iron Supplement</label>
            <label class="flex items-center"><input type="checkbox" name="supplements_issued" value="Folic Acid" class="mr-2"> Folic Acid</label>
            <label class="flex items-center"><input type="checkbox" name="supplements_issued" value="Calcium" class="mr-2"> Calcium</label>
        </div>
        <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Supplements Issued (text)</label><input type="text" name="supplements_issued" value="{{ old('supplements_issued') }}" class="w-full px-3 py-2 border rounded-lg"></div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.index' : 'user.maternal.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700">Register Case</button>
        </div>
    </form>
</div>
@endsection
