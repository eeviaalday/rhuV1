<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImmunizationRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'user_id', 'vaccine_name', 'dose_number',
        'schedule_date', 'date_given', 'batch_number', 'expiry_date',
        'administered_by', 'injection_site', 'next_due_date', 'remarks'
    ];
    
    protected $casts = [
        'schedule_date' => 'date',
        'date_given' => 'date',
        'expiry_date' => 'date',
        'next_due_date' => 'date',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
