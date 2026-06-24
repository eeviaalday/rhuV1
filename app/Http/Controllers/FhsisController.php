<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MorbidityRecord;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\ImmunizationRecord;
use App\Models\MaternalCase;
use Carbon\Carbon;
use PDF;

class FhsisController extends Controller
{
    public function index()
    {
        return view('fhsis.index');
    }

    public function m1(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;

        $ageGroups = [
            '10-14' => ['min' => 10, 'max' => 14],
            '15-19' => ['min' => 15, 'max' => 19],
            '20-49' => ['min' => 20, 'max' => 49],
        ];

        $familyPlanning = [];
        foreach ($ageGroups as $group => $range) {
            $familyPlanning[$group] = [
                'pills' => 0, 'injectables' => 0, 'implants' => 0,
                'iud' => 0, 'condoms' => 0, 'sterilization' => 0,
            ];
        }

        $dewormingStats = [
            'children' => Patient::whereYear('birthdate', '>=', $year - 5)->count(),
            'adults' => Patient::whereYear('birthdate', '<', $year - 5)->count(),
        ];

        return view('fhsis.m1', compact('year', 'familyPlanning', 'dewormingStats'));
    }

    public function m2(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? Carbon::now()->month;

        $records = MorbidityRecord::where('is_notifiable', true)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->with('patient')
            ->get();

        return view('fhsis.m2', compact('records', 'year', 'month'));
    }

    public function quarterly(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $quarter = $request->quarter ?? Carbon::now()->quarter;

        $startMonth = ($quarter - 1) * 3 + 1;
        $endMonth = $quarter * 3;

        $records = MorbidityRecord::where('is_notifiable', true)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', '>=', $startMonth)
            ->whereMonth('created_at', '<=', $endMonth)
            ->with('patient')
            ->get();

        $consultations = Consultation::whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->count();

        return view('fhsis.quarterly', compact('records', 'consultations', 'year', 'quarter'));
    }

    public function annual(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;

        $records = MorbidityRecord::whereYear('created_at', $year)
            ->with('patient')
            ->get();

        $consultations = Consultation::whereYear('date', $year)->count();
        $maternalCases = MaternalCase::whereYear('created_at', $year)->count();
        $immunizations = ImmunizationRecord::whereYear('created_at', $year)->count();

        return view('fhsis.annual', compact('records', 'consultations', 'maternalCases', 'immunizations', 'year'));
    }

    public function exportPdf($type, Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? Carbon::now()->month;

        $data = [];

        if ($type === 'm1') {
            $data = ['title' => 'M1 Monthly Health Statistics', 'year' => $year];
            $view = 'fhsis.pdf_m1';
        } elseif ($type === 'm2') {
            $records = MorbidityRecord::where('is_notifiable', true)
                ->whereYear('created_at', $year)->whereMonth('created_at', $month)
                ->with('patient')->get();
            $data = ['title' => 'M2 Monthly Notifiable Disease Report', 'records' => $records, 'year' => $year, 'month' => $month];
            $view = 'fhsis.pdf_m2';
        } elseif ($type === 'quarterly') {
            $data = ['title' => 'Quarterly Summary', 'year' => $year];
            $view = 'fhsis.pdf_quarterly';
        } elseif ($type === 'annual') {
            $data = ['title' => 'Annual Summary', 'year' => $year];
            $view = 'fhsis.pdf_annual';
        } else {
            abort(404);
        }

        $pdf = PDF::loadView($view, $data);
        return $pdf->download("{$type}_{$year}.pdf");
    }

    public function print()
    {
        return view('fhsis.print');
    }
}
