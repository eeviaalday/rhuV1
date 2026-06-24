<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntenatalCare extends Model
{
    use HasFactory;
    protected $fillable = [
        'prenatal_visit_id', 'tetanus_toxoid', 'anti_helminthic',
        'iron_folate', 'counseling_done', 'next_schedule'
    ];
    
    protected $casts = [
        'anti_helminthic' => 'boolean',
        'iron_folate' => 'boolean',
        'counseling_done' => 'boolean',
        'next_schedule' => 'date',
    ];
    
    public function prenatalVisit()
    {
        return $this->belongsTo(PrenatalVisit::class);
    }
}
