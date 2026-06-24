<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'rhu_code', 'location', 'accreditation_status'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
