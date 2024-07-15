<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table ='class_rooms';

    protected $fillable = [
        'cr_name',
        'cr_status',
        'cr_deleted',
        'cr_created_by',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class,'cr_created_by','id');
    }

    public function tb_class_room_primarykey(){
        return $this->hasMany(assign_subject::class,'class_id','id');
    }
}

