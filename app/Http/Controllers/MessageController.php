<?php
namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = $this->messageService->getChatUsers($search);
        $messages = $this->messageService->getAllMessages();
        $userId = $request->query('userId');
        $chatData = $userId ? $this->messageService->getOrStartChatWithUser($userId) : null;

        return view('user.account.chat', compact('users', 'messages', 'chatData', 'userId'));
    }

    public function show($userId)
    {
        $chatData = $this->messageService->getOrStartChatWithUser($userId);
        return view('user.account.message', $chatData);
    }

    public function store(Request $request)
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