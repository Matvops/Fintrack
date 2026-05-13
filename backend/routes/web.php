<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(DB::connection()->getPdo()) {
        return 'Database connection is successful!';
    } else {
        return 'Database connection failed.';
    }
});
