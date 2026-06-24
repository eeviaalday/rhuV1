<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrenatalVisit extends Model
{
    use HasFactory;
    protected $fillable = [
        'maternal_case_id', 'visit_date', 'weight', 'blood_pressure',
        'fundal_height', 'fetal_heart_rate', 'fetal_movement',
        'age_of_gestation', 'presentation', 'edema'
    ];
    
    protected $casts = ['visit_date' => 'date'];
    
    public function maternalCase()
    {
        return $this->belongsTo(MaternalCase::class);
    }
    
    public function antenatalCare()
    {
        return $this->hasOne(AntenatalCare::class);
    }
    
    public function abdominalExam()
    {
        return $this->hasOne(AbdominalExam::class);
    }
}
