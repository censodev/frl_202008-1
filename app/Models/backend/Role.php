<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
    	'name', 'description',
    ];

    public function Users() {
	  return $this->belongsToMany(User::class);
	}
}
