<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckManage extends Model
{

    protected $table = "truck_manages";
    protected $fillable = ['name'];


    public function users()
    {
        return $this->hasMany(User::class,'truck_id','id');
    }
}
