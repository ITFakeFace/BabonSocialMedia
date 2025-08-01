<?php

use App\Events\TypingEvent;
use http\Client\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('messenger.{sender}.{receiver}', function ($user) {
    return !is_null($user);
});
Broadcast::channel('messenger.{receiver}', function ($user) {
    return !is_null($user);
});


