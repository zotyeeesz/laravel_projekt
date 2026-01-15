<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\felhasznalo;
use App\Models\koltes;
use App\Models\kategoria;
use App\Models\penznem;

Route::get('/', function () {
    return view('login');
});
//koltsegfigyelo.test/login
Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function () {
    $user = felhasznalo::where('email', request('email'))->first();
    
    if ($user && Hash::check(request('password'), $user->password)) {
        session(['user' => $user]);
        return redirect('/fooldal');
    }
    
    return back()->withErrors(['Helytelen email vagy jelszó!']);
});

Route::get('/logout', function () {
    session()->forget('user');
    return redirect('/login');
});
//

//koltsegfigyelo.test/fooldal
Route::get('/fooldal', function () {
    if (!session('user')) {
        return redirect('/login');
    }
    $koltes = koltes::where('felhasznaloid', session('user')->id)->get();
    $kategoriak = kategoria::where('felhasznaloid', session('user')->id)->orWhereNull('felhasznaloid')->orderBy('nev', 'asc')->get();
    $penznemek = penznem::all();
    return view('fooldal', ['koltes' => $koltes, 'kategoriak' => $kategoriak, 'penznemek' => $penznemek]);
});

Route::get('/teszt', function () {
    $felhasznalo = felhasznalo::all();
    return view('teszt', ['felhasznalo' => $felhasznalo]);
});

Route::get('/felhasznalo/add', function () {
    return view('felhasznalo_hozzaadas');
});

Route::post('/felhasznalo/add', function () {
    felhasznalo::create([
        'nev' => request('nev'),
        'email' => request('email'),
        'password' => Hash::make(request('password'))
    ]);
    return redirect('/login')->with('success', 'Regisztráció sikeres! Jelentkezz be!');
});

Route::post('/koltseg/add', function () {
    if (!session('user')) {
        return redirect('/login');
    }
    
    $kategoriaNev = request('kategoria');
    
    // Keres a kategória név alapján
    $kat = kategoria::where('felhasznaloid', session('user')->id)
                    ->where('nev', $kategoriaNev)
                    ->first();
    
    // Ha nem találja, új kategóriát hoz létre
    if (!$kat) {
        $kat = kategoria::create([
            'felhasznaloid' => session('user')->id,
            'nev' => $kategoriaNev
        ]);
    }
    
    koltes::create([
        'felhasznaloid' => session('user')->id,
        'kategoriaid' => kategoria::where('nev', $kategoriaNev)->first()->id ?? $kat->id,
        'penznemid' => penznem::where('nev', request('penznem'))->first()->id,
        'osszeg' => request('osszeg'),
        'megjegyzes' => request('megjegyzes'),
        'rogzites' => request('rogzites')
    ]);
    
    return redirect('/fooldal')->with('success', 'Költség sikeresen hozzáadva!');
});


Route::post('/kategoria/add', function () {
    if (!session('user')) {
        return redirect('/login');
    }
    
    $kategoria = kategoria::create([
        'felhasznaloid' => session('user')->id,
        'nev' => request('kategoria_nev')
    ]);
    
    return response()->json(['success' => true, 'kategoriaid' => $kategoria->id, 'kategoria_nev' => $kategoria->nev]);
    return redirect('/fooldal')->with('success', 'Költség sikeresen hozzáadva!');
});