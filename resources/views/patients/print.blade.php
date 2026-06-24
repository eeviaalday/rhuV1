<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>{{ $patient->full_name }} - Patient Record</title><style>body{font-family:Arial,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse;margin-bottom:20px}td,th{border:1px solid #000;padding:6px;text-align:left}h2{text-align:center}.header{text-align:center;margin-bottom:20px}</style></head>
<body onload="window.print()">
<div class="header"><h2>Rural Health Unit Peñarrubia</h2><h3>Patient Record</h3></div>
<h3>Personal Information</h3>
<table><tr><td>Name:</td><td>{{ $patient->full_name }}</td><td>Birthdate:</td><td>{{ $patient->birthdate ? $patient->birthdate->format('M d, Y') : 'N/A' }}</td></tr>
<tr><td>Sex:</td><td>{{ $patient->sex }}</td><td>Blood Type:</td><td>{{ $patient->blood_type ?? 'N/A' }}</td></tr>
<tr><td>PhilHealth:</td><td>{{ $patient->philhealth_number ?? 'N/A' }}</td><td>Barangay:</td><td>{{ $patient->barangay }}</td></tr>
<tr><td>Contact:</td><td>{{ $patient->contact_number ?? 'N/A' }}</td><td>4Ps:</td><td>{{ $patient->is_4ps ? 'Yes' : 'No' }}</td></tr>
<tr><td>Religion:</td><td>{{ $patient->religion ?? 'N/A' }}</td><td>Ethnicity:</td><td>{{ $patient->ethnicity ?? 'N/A' }}</td></tr></table>
@if($patient->medicalBackground)
<h3>Medical Background</h3>
<table><tr><th>Allergies</th><td>{{ $patient->medicalBackground->allergies ?? 'None' }}</td></tr>
<tr><th>Medical Conditions</th><td>{{ $patient->medicalBackground->medical_conditions ?? 'None' }}</td></tr>
<tr><th>Medications</th><td>{{ $patient->medicalBackground->medications ?? 'None' }}</td></tr>
<tr><th>Surgical History</th><td>{{ $patient->medicalBackground->surgical_history ?? 'None' }}</td></tr>
<tr><th>Family History</th><td>{{ $patient->medicalBackground->family_history ?? 'None' }}</td></tr></table>
@endif
<p style="text-align:center;margin-top:30px;color:#666;">Printed on {{ now()->format('F d, Y h:i A') }}</p>
</body></html>
