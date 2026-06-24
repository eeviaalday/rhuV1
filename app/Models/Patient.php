<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'last_name', 'first_name', 'middle_name', 'birthdate', 'sex',
        'blood_type', 'philhealth_number', 'religion', 'ethnicity',
        'is_4ps', 'barangay', 'province', 'contact_number',
        'emergency_contact_name', 'emergency_contact_number',
        'is_archived', 'archived_reason'
    ];
    
    protected $casts = [
        'birthdate' => 'date',
        'is_4ps' => 'boolean',
        'is_archived' => 'boolean',
    ];
    
    public function medicalBackground()
    {
        return $this->hasOne(PatientMedicalBackground::class);
    }
    
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
    
    public function maternalCases()
    {
        return $this->hasMany(MaternalCase::class);
    }
    
    public function immunizationRecords()
    {
        return $this->hasMany(ImmunizationRecord::class);
    }
    
    public function morbidityRecords()
    {
        return $this->hasMany(MorbidityRecord::class);
    }
    
    public function getFullNameAttribute()
    {
        return trim($this->last_name . ', ' . $this->first_name . ' ' . ($this->middle_name ?? ''));
    }
    
    public function getAgeAttribute()
    {
        return $this->birthdate ? $this->birthdate->age : null;
    }
}
