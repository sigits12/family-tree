<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
	protected $table = 'anggota';
	protected $primaryKey = 'id';

	protected $guarded = ['id']; 

	public function parent()
    {
        return $this->belongsTo('App\Models\Anggota', 'id_orang_tua');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Anggota', 'id_orang_tua');
    }
}
