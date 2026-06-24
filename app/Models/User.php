<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'facility_id', 'first_name', 'middle_name', 'last_name',
        'username', 'password', 'role', 'designation', 'contact_number',
        'sex', 'birthdate', 'civil_status', 'blood_type', 'barangay',
        'philhealth_id', 'is_active', 'last_login', 'last_password_change'
    ];
    
    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = [
        'birthdate' => 'date',
        'is_active' => 'boolean',
        'last_login' => 'datetime',
        'last_password_change' => 'datetime',
    ];
    
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
    
    public function securityQuestions()
    {
        return $this->hasMany(SecurityQuestion::class);
    }
    
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
    
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
    
    public function immunizationRecords()
    {
        return $this->hasMany(ImmunizationRecord::class);
    }
    
    public function morbidityRecords()
    {
        return $this->hasMany(MorbidityRecord::class);
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name);
    }
}
