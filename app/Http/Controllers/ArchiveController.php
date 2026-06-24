<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\AuditLog;
use Carbon\Carbon;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::where('is_archived', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $totalArchived = Patient::where('is_archived', true)->count();
        $transferred = Patient::where('is_archived', true)->where('archived_reason', 'Transferred')->count();
        $deceased = Patient::where('is_archived', true)->where('archived_reason', 'Deceased')->count();
        $inactive2yrs = Patient::where('is_archived', true)->where('updated_at', '<=', Carbon::now()->subYears(2))->count();

        $patients = $query->latest()->paginate(15);

        return view('archive.index', compact('patients', 'totalArchived', 'transferred', 'deceased', 'inactive2yrs'));
    }

    public function restore(Patient $patient)
    {
        $patient->update(['is_archived' => false, 'archived_reason' => null]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'restore',
            'module' => 'patient',
            'record_id' => $patient->id,
            'description' => 'Restored patient: ' . $patient->full_name,
        ]);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.archive.index' : 'user.archive.index')
            ->with('success', 'Patient restored successfully.');
    }

    public function exportCsv()
    {
        $patients = Patient::where('is_archived', true)->get();
        $filename = 'archived_patients_' . Carbon::now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($patients) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Last Name', 'First Name', 'Middle Name', 'Birthdate', 'Sex', 'Barangay', 'Archived Reason', 'Archived Date']);

            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->last_name,
                    $patient->first_name,
                    $patient->middle_name,
                    $patient->birthdate ? $patient->birthdate->format('Y-m-d') : '',
                    $patient->sex,
                    $patient->barangay,
                    $patient->archived_reason,
                    $patient->updated_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
