<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalBackground extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'allergies', 'medical_conditions',
        'medications', 'surgical_history', 'family_history'
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
