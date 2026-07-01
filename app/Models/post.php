<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = ["name"];
    protected $guarded = ["id"];
    // protected $hidden = [""];
    public function user(){
        $this->belongsTo(User::class);
        
    }
}
