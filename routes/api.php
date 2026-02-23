<?php

use Illuminate\Support\Facades\Route;

Route::get(uri: "/", action: function (): string {
    return "API";
});
