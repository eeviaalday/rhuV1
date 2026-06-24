@extends('layouts.admin')
@section('title', 'Add Prenatal Visit')
@section('header', 'Prenatal Visit - ' . $maternalCase->patient->full_name)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.visits.store' : 'user.maternal.visits.store', $maternalCase->id) }}">
        @csrf
        <div x-data="{ tab: 'prenatal' }">
            <div class="border-b flex mb-4">
                <button type="button" @click="tab = 'prenatal'" :class="{ 'border-b-2 border-pink-500 text-pink-600': tab === 'prenatal' }" class="px-4 py-3 text-sm font-medium">Prenatal Exam</button>
                <button type="button" @click="tab = 'antenatal'" :class="{ 'border-b-2 border-pink-500 text-pink-600': tab === 'antenatal' }" class="px-4 py-3 text-sm font-medium">Antenatal Care</button>
                <button type="button" @click="tab = 'abdominal'" :class="{ 'border-b-2 border-pink-500 text-pink-600': tab === 'abdominal' }" class="px-4 py-3 text-sm font-medium">Abdominal Exam</button>
                <button type="button" @click="tab = 'postpartum'" :class="{ 'border-b-2 border-pink-500 text-pink-600': tab === 'postpartum' }" class="px-4 py-3 text-sm font-medium">Postpartum & Neonatal</button>
            </div>
            <div x-show="tab === 'prenatal'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Visit Date *</label><input type="date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" class="w-full px-3 py-2 border rounded-lg" required></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Weight (kg)</label><input type="text" name="weight" value="{{ old('weight') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Blood Pressure</label><input type="text" name="blood_pressure" value="{{ old('blood_pressure') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Fundal Height (cm)</label><input type="text" name="fundal_height" value="{{ old('fundal_height') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Fetal Heart Rate</label><input type="text" name="fetal_heart_rate" value="{{ old('fetal_heart_rate') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Fetal Movement</label><select name="fetal_movement" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Active">Active</option><option value="Normal">Normal</option><option value="Decreased">Decreased</option><option value="None">None</option></select></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Age of Gestation</label><input type="text" name="age_of_gestation" value="{{ old('age_of_gestation') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Presentation</label><select name="presentation" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Cephalic">Cephalic</option><option value="Breech">Breech</option><option value="Transverse">Transverse</option></select></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Edema</label><select name="edema" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="None">None</option><option value="Mild">Mild</option><option value="Moderate">Moderate</option><option value="Severe">Severe</option></select></div>
                </div>
            </div>
            <div x-show="tab === 'antenatal'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Tetanus Toxoid</label><select name="tetanus_toxoid" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="TT1">TT1</option><option value="TT2">TT2</option><option value="TT3">TT3</option><option value="TT4">TT4</option><option value="TT5">TT5</option><option value="Booster">Booster</option></select></div>
                    <div><label class="flex items-center"><input type="checkbox" name="anti_helminthic" value="1" class="mr-2"> Anti-Helminthic Given</label></div>
                    <div><label class="flex items-center"><input type="checkbox" name="iron_folate" value="1" class="mr-2"> Iron/Folate Given</label></div>
                    <div><label class="flex items-center"><input type="checkbox" name="counseling_done" value="1" class="mr-2"> Counseling Done</label></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Next Schedule</label><input type="date" name="next_schedule" value="{{ old('next_schedule') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                </div>
            </div>
            <div x-show="tab === 'abdominal'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Trimester</label><select name="trimester" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="1st">1st</option><option value="2nd">2nd</option><option value="3rd">3rd</option></select></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Fundic Height (cm)</label><input type="text" name="fundic_height_cm" value="{{ old('fundic_height_cm') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Fetal Heart Tones</label><select name="fetal_heart_tones" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Present">Present</option><option value="Absent">Absent</option><option value="Irregular">Irregular</option></select></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Leopold's Maneuver</label><textarea name="leopolds_maneuver" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('leopolds_maneuver') }}</textarea></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Uterine Activity</label><textarea name="uterine_activity" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('uterine_activity') }}</textarea></div>
                </div>
            </div>
            <div x-show="tab === 'postpartum'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Delivery Outcome</label><select name="delivery_outcome" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Live Birth">Live Birth</option><option value="Stillbirth">Stillbirth</option><option value="Miscarriage">Miscarriage</option><option value="Ongoing">Ongoing</option></select></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Baby Sex</label><select name="baby_sex" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Male">Male</option><option value="Female">Female</option></select></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Delivery Type</label><select name="delivery_type" class="w-full px-3 py-2 border rounded-lg"><option value="">Select</option><option value="Normal Spontaneous">Normal Spontaneous</option><option value="C-Section">C-Section</option><option value="Assisted">Assisted</option></select></div>
                    <div><label class="flex items-center"><input type="checkbox" name="amtsl_done" value="1" class="mr-2"> AMTSL Done</label></div>
                    <div><label class="flex items-center"><input type="checkbox" name="vitamin_k_given" value="1" class="mr-2"> Vitamin K Given</label></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Newborn Screening Result</label><input type="text" name="newborn_screening_result" value="{{ old('newborn_screening_result') }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-bold mb-2">Danger Signs</label><textarea name="danger_signs" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('danger_signs') }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.maternal.show' : 'user.maternal.show', $maternalCase->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700">Save Visit</button>
        </div>
    </form>
</div>
@endsection
