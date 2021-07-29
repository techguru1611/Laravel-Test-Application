<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $fillable = [
        'name',
        'category_id',
        'trade_license',
        'logo',
        'licensed_date',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories','category_id');
    }

    // get organization data
    public static function getOrganizationData()
    {   
        $query = Organization::with('category')->paginate(10);
        return $query;
    }
}
