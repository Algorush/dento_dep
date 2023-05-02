<?php

use Illuminate\Foundation\Inspiring;
use Webpatser\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('update_uniqid', function () {
    $dealRepo =  new \App\Deal\DealRepo();

    $deals = $dealRepo->getAll(null, true);
    foreach ($deals as $deal){
        $uniqid = uniqid('');

        $deal->uniqid = $uniqid;
        $deal->save();
    }
});
