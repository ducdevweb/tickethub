<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    public function getChatUsers($search = null)
    {
        $query = User::where('id', '!=', Auth::id());
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        } else {
            $query->whereHas('sentMessages', function ($q) {
                $q->where('receiver_id', Auth::id());
            })->orWhereHas('receivedMessages', function ($q) {
                $q->where('sender_id', Auth::id());
            });
        }
    
        return $query->with(['receivedMessages', 'sentMessages'])->get(); 
    }

    public function getAllMessages()
    {
        return Message::where(function ($query) {
            $query->where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id());
        })
            ->with('sender', 'receiver')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getMessagesWithUser($userId)
    {
        return Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $userId)
                ->orWhere('sender_id', $userId)->where('receiver_id', Auth::id());
        })
            ->with('sender', 'receiver')
            ->orderBy('created_at', 'asc')
            ->get();
    }


    public function sendMessage($receiverId, $messageContent)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $messageContent,
        ]);

        event(new MessageSent($message));

        return $message;
    }

    public function getOrStartChatWithUser($userId)
    {
        $selectedUser = User::findOrFail($userId);
        $messages = $this->getMessagesWithUser($userId);

        return [
            'selectedUser' => $selectedUser,
            'messages' => $messages,
        ];
    }
 
}
