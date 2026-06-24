<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientMedicalBackground;
use App\Models\AuditLog;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::where('is_archived', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('philhealth_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('barangay')) {
            $query->where('barangay', $request->barangay);
        }

        $patients = $query->orderBy('last_name')->paginate(15);
        $barangays = Patient::select('barangay')->distinct()->whereNotNull('barangay')->orderBy('barangay')->pluck('barangay');

        return view('patients.index', compact('patients', 'barangays'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'sex' => 'required|string',
            'blood_type' => 'nullable|string',
            'philhealth_number' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'is_4ps' => 'boolean',
            'barangay' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_number' => 'nullable|string|max:255',
        ]);

        $patient = Patient::create($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'patient',
            'record_id' => $patient->id,
            'description' => 'Created patient record for ' . $patient->full_name,
        ]);

        if ($request->has('redirect_to_medical')) {
            return redirect()->route(auth()->user()->isAdmin() ? 'admin.patients.medical_background' : 'user.patients.medical_background', $patient->id)
                ->with('success', 'Patient created. Now add medical background.');
        }

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.patients.index' : 'user.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['medicalBackground', 'consultations' => function ($q) {
            $q->latest()->limit(10);
        }, 'maternalCases', 'immunizationRecords', 'morbidityRecords']);
        
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'sex' => 'required|string',
            'blood_type' => 'nullable|string',
            'philhealth_number' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'is_4ps' => 'boolean',
            'barangay' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_number' => 'nullable|string|max:255',
        ]);

        $patient->update($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'patient',
            'record_id' => $patient->id,
            'description' => 'Updated patient record for ' . $patient->full_name,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $patient->id)
            ->with('success', 'Patient updated successfully.');
    }

    public function medicalBackground(Patient $patient)
    {
        $background = $patient->medicalBackground;
        return view('patients.medical_background', compact('patient', 'background'));
    }

    public function storeMedicalBackground(Request $request, Patient $patient)
    {
        $request->validate([
            'allergies' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'medications' => 'nullable|string',
            'surgical_history' => 'nullable|string',
            'family_history' => 'nullable|string',
        ]);

        PatientMedicalBackground::updateOrCreate(
            ['patient_id' => $patient->id],
            $request->only(['allergies', 'medical_conditions', 'medications', 'surgical_history', 'family_history'])
        );

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'patient_medical_background',
            'record_id' => $patient->id,
            'description' => 'Updated medical background for ' . $patient->full_name,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.patients.show' : 'user.patients.show', $patient->id)
            ->with('success', 'Medical background saved successfully.');
    }

    public function print(Patient $patient)
    {
        $patient->load('medicalBackground');
        return view('patients.print', compact('patient'));
    }
}
