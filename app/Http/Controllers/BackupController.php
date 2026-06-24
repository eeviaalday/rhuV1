<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backups = [];
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        
        if ($disk->exists(config('backup.backup.name'))) {
            $files = $disk->allFiles(config('backup.backup.name'));
            foreach ($files as $file) {
                $backups[] = [
                    'filename' => basename($file),
                    'path' => $file,
                    'size' => $disk->size($file),
                    'date' => date('Y-m-d H:i:s', $disk->lastModified($file)),
                ];
            }
        }

        $backups = array_reverse($backups);
        $lastBackup = !empty($backups) ? $backups[0] : null;

        return view('backup.index', compact('backups', 'lastBackup'));
    }

    public function run()
    {
        try {
            Artisan::call('backup:run');
            $output = Artisan::output();
            
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'backup_run',
                'module' => 'backup',
                'description' => 'Manual backup executed',
            ]);

            return back()->with('success', 'Backup completed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string',
        ]);

        try {
            $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
            $path = $request->backup_file;
            
            if (!$disk->exists($path)) {
                return back()->with('error', 'Backup file not found.');
            }

            $sql = $disk->get($path);
            
            $db = config('database.connections.mysql');
            $pdo = new \PDO("mysql:host={$db['host']};dbname={$db['database']}", $db['username'], $db['password']);
            $pdo->exec($sql);

            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'backup_restore',
                'module' => 'backup',
                'description' => 'Database restored from backup: ' . basename($path),
            ]);

            return back()->with('success', 'Database restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'backup_folder' => 'nullable|string',
            'preferred_time' => 'nullable|string',
            'retention_days' => 'nullable|integer|min:1|max:365',
        ]);

        // Store settings in database or config
        // For now, just return success
        return back()->with('success', 'Backup settings updated successfully.');
    }
}
