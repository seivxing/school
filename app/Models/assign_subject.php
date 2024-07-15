<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assign_subject extends Model
{
    use HasFactory;

    protected $table ='assign_subjects';

    protected $fillable = [
        'class_id',
        'subject_id',
        'as_create_by',
        'as_status',
        'as_delete',
    ];

    public function getClassid_foreignkey(){
        return $this->belongsTo(ClassRoom::class,'class_id','id');
    }

    public function getSubjectid_foreignkey(){
        return $this->belongsTo(Subjects::class,'subject_id','id');
    }
    
    public function getuserid_foreignkey(){
        return $this->belongsTo(User::class,'as_create_by','id');
    }
    
}
