<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbdominalExam extends Model
{
    use HasFactory;
    protected $fillable = [
        'prenatal_visit_id', 'trimester', 'fundic_height_cm',
        'fetal_heart_tones', 'leopolds_maneuver', 'uterine_activity'
    ];
    
    public function prenatalVisit()
    {
        return $this->belongsTo(PrenatalVisit::class);
    }
}
