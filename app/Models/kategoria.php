<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategoria extends Model
{
    protected $table = 'kategoria';

    protected $fillable = [
        'felhasznaloid',
        'nev',
    ];
}
