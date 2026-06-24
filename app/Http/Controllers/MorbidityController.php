<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MorbidityRecord;
use App\Models\Patient;
use App\Models\AuditLog;
use Carbon\Carbon;

class MorbidityController extends Controller
{
    public function index(Request $request)
    {
        $query = MorbidityRecord::with('patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhere('diagnosis', 'like', "%{$search}%")
              ->orWhere('icd10_code', 'like', "%{$search}%");
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('barangay')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $total = MorbidityRecord::count();
        $notifiable = MorbidityRecord::where('is_notifiable', true)->count();
        $recovered = MorbidityRecord::where('outcome', 'recovered')->count();
        $deceased = MorbidityRecord::where('outcome', 'deceased')->count();

        $records = $query->latest()->paginate(15);

        return view('morbidity.index', compact('records', 'total', 'notifiable', 'recovered', 'deceased'));
    }

    public function create()
    {
        $patients = Patient::where('is_archived', false)->orderBy('last_name')->get();
        return view('morbidity.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'icd10_code' => 'nullable|string',
            'disease_category' => 'nullable|string',
            'severity' => 'nullable|string',
            'is_notifiable' => 'boolean',
            'outcome' => 'nullable|in:recovered,referred,deceased',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $record = MorbidityRecord::create($data);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'morbidity',
            'record_id' => $record->id,
            'description' => 'Recorded morbidity: ' . $request->diagnosis,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.morbidity.index' : 'user.morbidity.index')
            ->with('success', 'Morbidity record created.');
    }

    public function show(MorbidityRecord $morbidity)
    {
        $morbidity->load('patient');
        return view('morbidity.show', compact('morbidity'));
    }

    public function edit(MorbidityRecord $morbidity)
    {
        $patients = Patient::where('is_archived', false)->orderBy('last_name')->get();
        return view('morbidity.edit', compact('morbidity', 'patients'));
    }

    public function update(Request $request, MorbidityRecord $morbidity)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'icd10_code' => 'nullable|string',
            'disease_category' => 'nullable|string',
            'severity' => 'nullable|string',
            'is_notifiable' => 'boolean',
            'outcome' => 'nullable|in:recovered,referred,deceased',
        ]);

        $morbidity->update($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'morbidity',
            'record_id' => $morbidity->id,
            'description' => 'Updated morbidity record #' . $morbidity->id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.morbidity.index' : 'user.morbidity.index')
            ->with('success', 'Morbidity record updated.');
    }
}
