<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class koltes extends Model
{
    protected $table = 'koltes';

    protected $fillable = [
        'felhasznaloid',
        'kategoriaid',
        'rogzites',
        'penznemid',
        'osszeg',
        'megjegyzes',
    ];
    
    public function kategoria()
    {
        return $this->belongsTo(kategoria::class, 'kategoriaid');
    }
}
