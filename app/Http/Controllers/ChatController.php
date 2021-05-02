<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;

// Modelos
use App\Models\User;

use Chat;

class ChatController extends BaseController
{
    use ApiResponse;

    public function msg ()
    {
        $idUserIWantToChatWith = request('payload.id');
        $bodyMessage = request('payload.msg.textContent');

        $currentUser = auth()->user();
        $userYouWantToChatWith = User::findOrFail($idUserIWantToChatWith);

        $conversation = Chat::conversations()->between($currentUser, $userYouWantToChatWith);

        if (!$conversation) {
            $conversation = Chat::createConversation([
                $currentUser,
                $userYouWantToChatWith
            ])->makeDirect();
        }

        $message = Chat::message($bodyMessage)
            ->from($currentUser)
            ->to($conversation)
            ->send();

        return $message;
    }

    public function contacts ()
    {
        $query = request('q');
        $currentUser = auth()->user();
        $contacts = User::where('id', '!=', $currentUser->id)->get()->map(function($user) {
            return [
                'uid' => $user->id,
                'displayName' => $user->fullName,
                'about' => $user->person->about,
                'photoURL' => $user->person->avatar,
                'status' => $user->status
            ];
        });

        return $this->showResponse($contacts);
    }

    public function chatContacts ()
    {
        $query = request('q');
        $currentUser = auth()->user();
        $contacts = collect();
        foreach ($currentUser->participation as $participation) {
            $contact = $participation->conversation->getParticipants()->first(function ($participant) use ($currentUser) {
                return $participant->id != $currentUser->id;
            });
            $contacts->push([
                'uid' => $contact->id,
                'displayName' => $contact->fullName,
                'about' => $contact->person->about,
                'photoURL' => $contact->person->avatar,
                'status' => $contact->status
            ]);
        }

        return $this->showResponse($contacts);
    }

    public function chats ()
    {
        $currentUser = auth()->user();
        $chat = [];
        foreach ($currentUser->participation as $participation) {
            $conversation = $participation->conversation;

            $msgs = $conversation->messages->map(function ($msg) use ($currentUser) {
                return [
                    'textContent' => $msg->body,
                    'time' => $msg->created_at,
                    'isSent' => $msg->sender->id == $currentUser->id,
                    'isSeen' => $msg->getNotification($currentUser)->is_seen == 1
                ];
            });

            $contact = $conversation->getParticipants()->first(function ($participant) use ($currentUser) {
                return $participant->id != $currentUser->id;
            });


            $chat[$contact->id] = [
                'isPinned' => true,
                'msg' => $msgs
            ];
        }

        return $this->showResponse($chat);
    }

    public function markAllSeen ()
    {
        $idUserIWantToChatWith = request('id');
        $userYouWantToChatWith = User::findOrFail($idUserIWantToChatWith);
        $currentUser = auth()->user();

        Chat::conversations()->between($userYouWantToChatWith, $currentUser)->readAll($currentUser);

        return $this->showResponse([]);
    }

    public function setPinned ()
    {

    }
}
