<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MaternalCase;
use App\Models\Patient;
use App\Models\PrenatalVisit;
use App\Models\AntenatalCare;
use App\Models\AbdominalExam;
use App\Models\PostpartumNeonatal;
use App\Models\AuditLog;
use Carbon\Carbon;

class MaternalController extends Controller
{
    public function index(Request $request)
    {
        $query = MaternalCase::with('patient');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $firstTrimester = MaternalCase::whereHas('patient', function($q) { $q->where('is_archived', false); })->get()->filter(function($c) {
            return $c->lmp && $c->lmp->diffInWeeks(Carbon::now()) <= 12;
        })->count();

        $secondTrimester = MaternalCase::whereHas('patient', function($q) { $q->where('is_archived', false); })->get()->filter(function($c) {
            return $c->lmp && $c->lmp->diffInWeeks(Carbon::now()) > 12 && $c->lmp->diffInWeeks(Carbon::now()) <= 26;
        })->count();

        $thirdTrimester = MaternalCase::whereHas('patient', function($q) { $q->where('is_archived', false); })->get()->filter(function($c) {
            return $c->lmp && $c->lmp->diffInWeeks(Carbon::now()) > 26;
        })->count();

        $dueThisWeek = MaternalCase::whereHas('patient', function($q) { $q->where('is_archived', false); })->get()->filter(function($c) {
            return $c->edd && $c->edd->isBetween(Carbon::now(), Carbon::now()->addWeek());
        })->count();

        $cases = $query->latest()->paginate(15);

        return view('maternal.index', compact('cases', 'firstTrimester', 'secondTrimester', 'thirdTrimester', 'dueThisWeek'));
    }

    public function create()
    {
        $patients = Patient::where('is_archived', false)->where('sex', 'Female')->orderBy('last_name')->get();
        return view('maternal.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'lmp' => 'nullable|date',
            'edd' => 'nullable|date',
            'gravida' => 'nullable|integer',
            'parity' => 'nullable|integer',
            'living_children' => 'nullable|integer',
            'supplements_issued' => 'nullable|string',
        ]);

        $case = MaternalCase::create($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'maternal_case',
            'record_id' => $case->id,
            'description' => 'Created maternal case for patient #' . $request->patient_id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.maternal.index' : 'user.maternal.index')
            ->with('success', 'Maternal case registered successfully.');
    }

    public function show(MaternalCase $maternalCase)
    {
        $maternalCase->load(['patient', 'prenatalVisits.antenatalCare', 'prenatalVisits.abdominalExam', 'postpartumNeonatal']);
        $aog = $maternalCase->lmp ? $maternalCase->lmp->diffInWeeks(Carbon::now()) . ' weeks' : 'N/A';
        $trimester = 'N/A';
        if ($maternalCase->lmp) {
            $weeks = $maternalCase->lmp->diffInWeeks(Carbon::now());
            if ($weeks <= 12) $trimester = '1st Trimester';
            elseif ($weeks <= 26) $trimester = '2nd Trimester';
            else $trimester = '3rd Trimester';
        }
        return view('maternal.show', compact('maternalCase', 'aog', 'trimester'));
    }

    public function edit(MaternalCase $maternalCase)
    {
        $patients = Patient::where('is_archived', false)->where('sex', 'Female')->orderBy('last_name')->get();
        return view('maternal.edit', compact('maternalCase', 'patients'));
    }

    public function update(Request $request, MaternalCase $maternalCase)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'lmp' => 'nullable|date',
            'edd' => 'nullable|date',
            'gravida' => 'nullable|integer',
            'parity' => 'nullable|integer',
            'living_children' => 'nullable|integer',
            'supplements_issued' => 'nullable|string',
        ]);

        $maternalCase->update($request->all());

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'maternal_case',
            'record_id' => $maternalCase->id,
            'description' => 'Updated maternal case #' . $maternalCase->id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.maternal.index' : 'user.maternal.index')
            ->with('success', 'Maternal case updated successfully.');
    }

    public function createVisit(MaternalCase $maternalCase)
    {
        $maternalCase->load('patient');
        return view('maternal.visits.create', compact('maternalCase'));
    }

    public function storeVisit(Request $request, MaternalCase $maternalCase)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'weight' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'fundal_height' => 'nullable|string',
            'fetal_heart_rate' => 'nullable|string',
            'fetal_movement' => 'nullable|string',
            'age_of_gestation' => 'nullable|string',
            'presentation' => 'nullable|string',
            'edema' => 'nullable|string',
            // Antenatal Care
            'tetanus_toxoid' => 'nullable|string',
            'anti_helminthic' => 'boolean',
            'iron_folate' => 'boolean',
            'counseling_done' => 'boolean',
            'next_schedule' => 'nullable|date',
            // Abdominal Exam
            'trimester' => 'nullable|string',
            'fundic_height_cm' => 'nullable|string',
            'fetal_heart_tones' => 'nullable|string',
            'leopolds_maneuver' => 'nullable|string',
            'uterine_activity' => 'nullable|string',
            // Postpartum
            'delivery_outcome' => 'nullable|string',
            'baby_sex' => 'nullable|string',
            'delivery_type' => 'nullable|string',
            'amtsl_done' => 'boolean',
            'danger_signs' => 'nullable|string',
            'vitamin_k_given' => 'boolean',
            'newborn_screening_result' => 'nullable|string',
        ]);

        $visit = PrenatalVisit::create([
            'maternal_case_id' => $maternalCase->id,
            'visit_date' => $request->visit_date,
            'weight' => $request->weight,
            'blood_pressure' => $request->blood_pressure,
            'fundal_height' => $request->fundal_height,
            'fetal_heart_rate' => $request->fetal_heart_rate,
            'fetal_movement' => $request->fetal_movement,
            'age_of_gestation' => $request->age_of_gestation,
            'presentation' => $request->presentation,
            'edema' => $request->edema,
        ]);

        AntenatalCare::create([
            'prenatal_visit_id' => $visit->id,
            'tetanus_toxoid' => $request->tetanus_toxoid,
            'anti_helminthic' => $request->boolean('anti_helminthic'),
            'iron_folate' => $request->boolean('iron_folate'),
            'counseling_done' => $request->boolean('counseling_done'),
            'next_schedule' => $request->next_schedule,
        ]);

        AbdominalExam::create([
            'prenatal_visit_id' => $visit->id,
            'trimester' => $request->trimester,
            'fundic_height_cm' => $request->fundic_height_cm,
            'fetal_heart_tones' => $request->fetal_heart_tones,
            'leopolds_maneuver' => $request->leopolds_maneuver,
            'uterine_activity' => $request->uterine_activity,
        ]);

        if ($request->filled('delivery_outcome')) {
            PostpartumNeonatal::create([
                'maternal_case_id' => $maternalCase->id,
                'delivery_outcome' => $request->delivery_outcome,
                'baby_sex' => $request->baby_sex,
                'delivery_type' => $request->delivery_type,
                'amtsl_done' => $request->boolean('amtsl_done'),
                'danger_signs' => $request->danger_signs,
                'vitamin_k_given' => $request->boolean('vitamin_k_given'),
                'newborn_screening_result' => $request->newborn_screening_result,
            ]);
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'prenatal_visit',
            'record_id' => $visit->id,
            'description' => 'Added prenatal visit for maternal case #' . $maternalCase->id,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.maternal.show' : 'user.maternal.show', $maternalCase->id)
            ->with('success', 'Prenatal visit recorded successfully.');
    }

    public function showVisit(MaternalCase $maternalCase, PrenatalVisit $prenatalVisit)
    {
        $prenatalVisit->load(['antenatalCare', 'abdominalExam']);
        return view('maternal.visits.show', compact('maternalCase', 'prenatalVisit'));
    }
}
