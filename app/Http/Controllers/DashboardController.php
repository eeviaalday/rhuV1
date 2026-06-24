<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\MaternalCase;
use App\Models\PrenatalVisit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalPatients = Patient::count();
        $activePatients = Patient::where('is_archived', false)->count();
        $prenatalCases = MaternalCase::count();
        $todayConsultations = Consultation::whereDate('date', Carbon::today())->count();
        
        $recentPatients = Patient::latest()->take(10)->get();
        
        $patientsByBarangay = Patient::selectRaw('barangay, COUNT(*) as count')
            ->where('is_archived', false)
            ->groupBy('barangay')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalPatients', 'activePatients', 'prenatalCases',
            'todayConsultations', 'recentPatients', 'patientsByBarangay'
        ));
    }

    public function userDashboard()
    {
        $totalPatients = Patient::count();
        $todayConsultations = Consultation::whereDate('date', Carbon::today())->count();
        $myConsultations = Consultation::where('user_id', auth()->id())->count();
        
        return view('user.dashboard', compact('totalPatients', 'todayConsultations', 'myConsultations'));
    }
}
