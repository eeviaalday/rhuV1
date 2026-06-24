<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaternalCase extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'lmp', 'edd', 'gravida', 'parity',
        'living_children', 'supplements_issued'
    ];
    
    protected $casts = [
        'lmp' => 'date',
        'edd' => 'date',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function prenatalVisits()
    {
        return $this->hasMany(PrenatalVisit::class);
    }
    
    public function postpartumNeonatal()
    {
        return $this->hasMany(PostpartumNeonatal::class);
    }
}
