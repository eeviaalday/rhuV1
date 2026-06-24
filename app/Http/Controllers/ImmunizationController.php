<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ImmunizationRecord;
use App\Models\Patient;
use App\Models\AuditLog;
use Carbon\Carbon;

class ImmunizationController extends Controller
{
    public function index(Request $request)
    {
        $query = ImmunizationRecord::with('patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('barangay')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $fullyVaccinated = ImmunizationRecord::whereNotNull('date_given')->distinct('patient_id')->count('patient_id');
        $incomplete = ImmunizationRecord::whereNull('date_given')->distinct('patient_id')->count('patient_id');
        $overdue = ImmunizationRecord::whereNull('date_given')->where('schedule_date', '<', Carbon::now())->count();
        $dueThisWeek = ImmunizationRecord::whereNull('date_given')
            ->whereBetween('schedule_date', [Carbon::now(), Carbon::now()->addWeek()])->count();

        $records = $query->latest()->paginate(15);
        $barangays = Patient::select('barangay')->distinct()->whereNotNull('barangay')->orderBy('barangay')->pluck('barangay');

        return view('immunizations.index', compact('records', 'fullyVaccinated', 'incomplete', 'overdue', 'dueThisWeek', 'barangays'));
    }

    public function create()
    {
        $patients = Patient::where('is_archived', false)->orderBy('last_name')->get();
        $vaccines = ['BCG', 'Hep B', 'Pentavalent', 'OPV', 'IPV', 'PCV', 'MMR'];
        return view('immunizations.create', compact('patients', 'vaccines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vaccine_name' => 'required|string',
            'dose_number' => 'nullable|integer',
            'schedule_date' => 'nullable|date',
            'date_given' => 'nullable|date',
            'batch_number' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'administered_by' => 'nullable|string',
            'injection_site' => 'nullable|string',
            'next_due_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $record = ImmunizationRecord::create($data);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'immunization',
            'record_id' => $record->id,
            'description' => 'Recorded ' . $request->vaccine_name . ' immunization for patient #' . $request->patient_id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.immunizations.index' : 'user.immunizations.index')
            ->with('success', 'Immunization record saved.');
    }

    public function show(ImmunizationRecord $immunization)
    {
        $immunization->load('patient');
        return view('immunizations.show', compact('immunization'));
    }

    public function edit(ImmunizationRecord $immunization)
    {
        $patients = Patient::where('is_archived', false)->orderBy('last_name')->get();
        $vaccines = ['BCG', 'Hep B', 'Pentavalent', 'OPV', 'IPV', 'PCV', 'MMR'];
        return view('immunizations.edit', compact('immunization', 'patients', 'vaccines'));
    }

    public function update(Request $request, ImmunizationRecord $immunization)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vaccine_name' => 'required|string',
            'dose_number' => 'nullable|integer',
            'schedule_date' => 'nullable|date',
            'date_given' => 'nullable|date',
            'batch_number' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'administered_by' => 'nullable|string',
            'injection_site' => 'nullable|string',
            'next_due_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $immunization->update($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'immunization',
            'record_id' => $immunization->id,
            'description' => 'Updated immunization record #' . $immunization->id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.immunizations.index' : 'user.immunizations.index')
            ->with('success', 'Immunization record updated.');
    }
}
