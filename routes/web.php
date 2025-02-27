<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('setwebhoog', function(){
    $response = $telegram->setWebhook(['url' => 'https://example.com/<token>/webhook']);
});
