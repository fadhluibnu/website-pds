<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['pics', 'pihakTerkaits', 'histories', 'status'];
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    public function pics()
    {
        return $this->hasMany(Pic::class);
    }
    public function pihakTerkaits()
    {
        return $this->hasMany(PihakTerkait::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
}
