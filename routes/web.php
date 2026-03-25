<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) { // redirect to React app
        return redirect('app/customer/' . Auth::id() . '/documents');
    }

    return redirect('/app/login');
});

Route::get('/app/{any?}', fn () => view('spa.shell'))->where('any', '.*');
