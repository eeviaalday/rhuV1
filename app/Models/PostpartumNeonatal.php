<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostpartumNeonatal extends Model
{
    use HasFactory;
    protected $fillable = [
        'maternal_case_id', 'delivery_outcome', 'baby_sex',
        'delivery_type', 'amtsl_done', 'danger_signs',
        'vitamin_k_given', 'newborn_screening_result'
    ];
    
    protected $casts = [
        'amtsl_done' => 'boolean',
        'vitamin_k_given' => 'boolean',
    ];
    
    public function maternalCase()
    {
        return $this->belongsTo(MaternalCase::class);
    }
}
