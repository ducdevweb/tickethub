<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    protected $messageService;

    public function __construct(AdminMessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = $this->messageService->getChatUsers($search) ?? collect(); 
        $userId = $request->query('userId');
        $chatData = $userId ? $this->messageService->getOrStartChatWithUser($userId) : null;

        return view('admin.index.chat', compact('users', 'chatData', 'userId'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        try {
            $message = $this->messageService->sendMessage($request->receiver_id, $request->message);
            return response()->json([
                'success' => true,
                'message' => $message->message,
                'created_at' => $message->created_at->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}