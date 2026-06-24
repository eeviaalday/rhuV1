<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\MorbidityRecord;
use App\Models\AuditLog;
use Carbon\Carbon;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::with('patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhere('diagnosis', 'like', "%{$search}%");
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('barangay')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $todayCount = Consultation::whereDate('date', Carbon::today())->count();
        $monthlyCount = Consultation::whereMonth('date', Carbon::now()->month)->count();
        $referredCount = Consultation::where('is_referral', true)->count();
        $consultations = $query->latest('date')->paginate(15);

        return view('consultations.index', compact('consultations', 'todayCount', 'monthlyCount', 'referredCount'));
    }

    public function create()
    {
        $patients = Patient::where('is_archived', false)->orderBy('last_name')->get();
        return view('consultations.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'respiratory_rate' => 'nullable|string',
            'bmi' => 'nullable|string',
            'chief_complaint' => 'nullable|string',
            'findings' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'outcome' => 'nullable|string',
            'is_referral' => 'boolean',
            'is_notifiable' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        $consultation = Consultation::create($data);

        if ($request->is_notifiable) {
            MorbidityRecord::create([
                'patient_id' => $request->patient_id,
                'user_id' => auth()->id(),
                'consultation_id' => $consultation->id,
                'diagnosis' => $request->diagnosis ?? 'Not specified',
                'is_notifiable' => true,
            ]);
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'consultation',
            'record_id' => $consultation->id,
            'description' => 'Created consultation for patient #' . $request->patient_id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.consultations.index' : 'user.consultations.index')
            ->with('success', 'Consultation recorded successfully.');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load('patient');
        return view('consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        $patients = Patient::where('is_archived', false)->orderBy('last_name')->get();
        return view('consultations.edit', compact('consultation', 'patients'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'respiratory_rate' => 'nullable|string',
            'bmi' => 'nullable|string',
            'chief_complaint' => 'nullable|string',
            'findings' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'outcome' => 'nullable|string',
            'is_referral' => 'boolean',
            'is_notifiable' => 'boolean',
        ]);

        $consultation->update($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'consultation',
            'record_id' => $consultation->id,
            'description' => 'Updated consultation #' . $consultation->id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.consultations.index' : 'user.consultations.index')
            ->with('success', 'Consultation updated successfully.');
    }

    public function print(Consultation $consultation)
    {
        $consultation->load('patient');
        return view('consultations.print', compact('consultation'));
    }
}
