<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Consultation Record</title><style>body{font-family:Arial;font-size:12px}table{width:100%;border-collapse:collapse;margin:10px 0}td,th{border:1px solid #000;padding:6px}h2{text-align:center}</style></head><body onload="window.print()">
<h2>Rural Health Unit Peñarrubia</h2>
<h3 style="text-align:center">Consultation Record</h3>
<table><tr><td><strong>Patient:</strong> {{ $consultation->patient->full_name }}</td><td><strong>Date:</strong> {{ $consultation->date->format('M d, Y') }}</td></tr></table>
<table><tr><th>BP</th><th>Temp</th><th>HR</th><th>RR</th><th>BMI</th></tr><tr><td>{{ $consultation->blood_pressure ?? 'N/A' }}</td><td>{{ $consultation->temperature ?? 'N/A' }}</td><td>{{ $consultation->heart_rate ?? 'N/A' }}</td><td>{{ $consultation->respiratory_rate ?? 'N/A' }}</td><td>{{ $consultation->bmi ?? 'N/A' }}</td></tr></table>
<p><strong>Chief Complaint:</strong> {{ $consultation->chief_complaint ?? 'None' }}</p>
<p><strong>Findings:</strong> {{ $consultation->findings ?? 'None' }}</p>
<p><strong>Diagnosis:</strong> {{ $consultation->diagnosis ?? 'None' }}</p>
<p><strong>Prescription:</strong> {{ $consultation->prescription ?? 'None' }}</p>
<table><tr><td><strong>Outcome:</strong> {{ $consultation->outcome ?? 'N/A' }}</td><td><strong>Referral:</strong> {{ $consultation->is_referral ? 'Yes' : 'No' }}</td><td><strong>Notifiable:</strong> {{ $consultation->is_notifiable ? 'Yes' : 'No' }}</td></tr></table>
<p style="text-align:center;margin-top:30px">Printed on {{ now()->format('F d, Y h:i A') }}</p>
</body></html>
