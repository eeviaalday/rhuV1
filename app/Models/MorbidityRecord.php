<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MorbidityRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'user_id', 'consultation_id', 'diagnosis',
        'icd10_code', 'disease_category', 'severity', 'is_notifiable',
        'outcome', 'doh_submitted_at', 'locked_at'
    ];
    
    protected $casts = [
        'is_notifiable' => 'boolean',
        'doh_submitted_at' => 'datetime',
        'locked_at' => 'datetime',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
