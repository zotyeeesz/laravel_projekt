<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class felhasznalo extends Model
{
    protected $table = 'felhasznalo';

    protected $fillable = [
        'nev',
        'email',
        'password',
    ];
}
