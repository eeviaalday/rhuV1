@extends('layouts.admin')
@section('title', 'Backup & Restore')
@section('header', 'Backup & Restore')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">Backup Status</h3>
            @if($lastBackup)
            <p class="text-sm mb-2"><strong>Last Backup:</strong> {{ $lastBackup['date'] }}</p>
            <p class="text-sm mb-2"><strong>File:</strong> {{ $lastBackup['filename'] }}</p>
            <p class="text-sm mb-2"><strong>Size:</strong> {{ number_format($lastBackup['size'] / 1024, 2) }} KB</p>
            @else
            <p class="text-gray-500">No backups found.</p>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">Manual Backup</h3>
            <form method="POST" action="{{ route('admin.backup.run') }}">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Run Backup Now</button>
            </form>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Backup Settings</h3>
            <form method="POST" action="{{ route('admin.backup.settings') }}">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Backup Folder Path</label><input type="text" name="backup_folder" value="{{ config('backup.backup.destination.disks.0') ?? 'local' }}" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Preferred Time (24h)</label><input type="time" name="preferred_time" value="02:00" class="w-full px-3 py-2 border rounded-lg"></div>
                    <div><label class="block text-gray-700 text-sm font-bold mb-2">Retention Period (days)</label><input type="number" name="retention_days" value="30" class="w-full px-3 py-2 border rounded-lg"></div>
                </div>
                <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Settings</button>
            </form>
        </div>
    </div>
    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Backup History</h3>
            @if(count($backups))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="bg-gray-50"><th class="text-left py-2 px-3">Filename</th><th class="text-left py-2 px-3">Date</th><th class="text-left py-2 px-3">Size</th></tr></thead>
                    <tbody>@foreach($backups as $b)
                        <tr class="border-t"><td class="py-2 px-3">{{ $b['filename'] }}</td><td class="py-2 px-3">{{ $b['date'] }}</td><td class="py-2 px-3">{{ number_format($b['size'] / 1024, 2) }} KB</td></tr>
                    @endforeach</tbody>
                </table>
            </div>
            @else<p class="text-gray-500">No backup history.</p>@endif
        </div>
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="font-bold text-lg mb-4">Restore Database</h3>
            <form method="POST" action="{{ route('admin.backup.restore') }}" onsubmit="return confirm('Restore will replace all current data. Continue?')">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Backup File</label>
                    <select name="backup_file" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">Select file...</option>
                        @foreach($backups as $b)
                        <option value="{{ $b['path'] }}">{{ $b['filename'] }} ({{ $b['date'] }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Restore from Backup</button>
            </form>
        </div>
    </div>
</div>
@endsection
