<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casino extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "position_lat",
        "position_lng",
        "address",
        "hours",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function scopeWithDistance($query, $lat, $lng)
    {
        return $query->addSelect([
                "*",
                \DB::raw("(
                    3959
                    * acos(
                        cos(radians({$lat}))
                        * cos(radians(position_lat))
                        * cos(radians(position_lng) - radians({$lng}))
                        + sin(radians({$lat}))
                        * sin(radians(position_lat))
                    )
                ) as distance"),
            ]);
    }

    public function scopeClosest($query, $lat, $lng, $maxDistance = 20)
    {
        return $query->withDistance($lat, $lng)
                    ->having("distance", "<=", $maxDistance)
                    ->orderBy("distance");
    }
}
