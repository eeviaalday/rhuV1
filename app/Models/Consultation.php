<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'user_id', 'date', 'blood_pressure', 'temperature',
        'heart_rate', 'respiratory_rate', 'bmi', 'chief_complaint',
        'findings', 'diagnosis', 'prescription', 'outcome',
        'is_referral', 'is_notifiable'
    ];
    
    protected $casts = [
        'date' => 'date',
        'is_referral' => 'boolean',
        'is_notifiable' => 'boolean',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function morbidityRecord()
    {
        return $this->hasOne(MorbidityRecord::class);
    }
}
