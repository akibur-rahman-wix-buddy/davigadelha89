<?php

use App\Models\ChatGroup;
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

/* Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}); */


Broadcast::channel('chat.{receiver_id}', function ($user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});






//!! It's from chatgpt for group chat
// public function join(User $user, $conversation_id): bool
// {
//     $conversation = ChatGroup::find($conversation_id);

//     if ((int) $user->id === (int) $conversation->user_one_id || (int) $user->id === (int) $conversation->user_two_id) {
//         return true;
//     }

//     return false;
// }


