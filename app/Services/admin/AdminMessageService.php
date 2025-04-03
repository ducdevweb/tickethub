<?php

namespace App\Services\Admin;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMessageService
{
    public function getChatUsers($search = null)
    {
        // Lấy danh sách user đã nhắn tin với admin
        $query = User::where('id', '!=', Auth::id())
                     ->where('role', 0) // Chỉ lấy user thường
                     ->where(function ($q) {
                         $q->whereHas('sentMessages', function ($q) {
                             $q->where('receiver_id', Auth::id());
                         })->orWhereHas('receivedMessages', function ($q) {
                             $q->where('sender_id', Auth::id());
                         });
                     });

        // Tìm kiếm nếu có từ khóa
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Eager load tin nhắn liên quan
        $users = $query->with(['receivedMessages' => function ($q) {
            $q->where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id());
        }, 'sentMessages' => function ($q) {
            $q->where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id());
        }])->get();

        // Sắp xếp theo tin nhắn mới nhất
        $users = $users->sortByDesc(function ($user) {
            $lastMessage = $user->receivedMessages->merge($user->sentMessages)
                ->sortByDesc('created_at')
                ->first();
            return $lastMessage ? $lastMessage->created_at : null;
        });

        return $users;
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
        $selectedUser = User::where('role', 0)->findOrFail($userId); 
        $messages = $this->getMessagesWithUser($userId);

        return [
            'selectedUser' => $selectedUser,
            'messages' => $messages,
        ];
    }
}