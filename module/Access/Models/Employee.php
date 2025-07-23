<?php

namespace Module\Access\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Module\Market\Models\Area;
use Module\Market\Models\Zone;
use Module\Market\Models\Region;
use Module\Market\Models\Division;
use Module\Market\Models\Territory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'designation_id',
        'zone_id',
        'division_id',
        'region_id',
        'area_id',
        'territory_id',
        'contact',
        'address',
        'joining_date'
    ];

    protected $casts = [
        'joining_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designation() // used
    {
        return $this->belongsTo(Designation::class);
    }

    public function zone() // used
    {
        return $this->belongsTo(Zone::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }
}
