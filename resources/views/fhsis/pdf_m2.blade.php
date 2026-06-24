<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>M2 Report {{ $year }}</title><style>body{font-family:Arial,sans-serif;font-size:11px}table{width:100%;border-collapse:collapse;margin-bottom:15px}td,th{border:1px solid #000;padding:5px;text-align:left}h2{text-align:center;margin-bottom:5px}h3{text-align:center;margin-top:0;color:#666}</style></head>
<body>
<h2>Rural Health Unit Peñarrubia</h2>
<h3>M2 - Monthly Notifiable Disease Report</h3>
<p style="text-align:right">Period: {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}</p>
<table>
<thead><tr><th>Patient</th><th>Diagnosis</th><th>ICD-10</th><th>Severity</th><th>Outcome</th><th>Date</th></tr></thead>
<tbody>@forelse($records as $r)
<tr><td>{{ $r->patient->full_name ?? 'N/A' }}</td><td>{{ $r->diagnosis }}</td><td>{{ $r->icd10_code ?? 'N/A' }}</td><td>{{ $r->severity ?? 'N/A' }}</td><td>{{ ucfirst($r->outcome ?? 'N/A') }}</td><td>{{ $r->created_at->format('M d, Y') }}</td></tr>
@empty<tr><td colspan="6" style="text-align:center">No records</td></tr>@endforelse</tbody>
</table>
<p style="text-align:right">Generated: {{ now()->format('F d, Y') }}</p>
</body></html>
