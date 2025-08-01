<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\TypingEvent;
use App\Models\User;
use App\Repositories\ChatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{

    public function __construct(private ChatRepository $chat) {
        $this->chat = $chat;
    }

    /**
     * Chat view.
     *
     * @return Response
     */
    public function index(Request $request, $receiverId = null)
    {
        $receiverId = is_numeric($receiverId) ? (int) $receiverId : null;
        $messages = empty($receiverId) ? [] : $this->chat->getUserMessages($request->user()->id, $receiverId);

        return Inertia::render('Chat/Chat', [
            'messages' => $messages,
            'recentMessages' => $this->chat->getRecentUsersWithMessage($request->user()->id),
            'auth' => $this->chat->getUser($request->user()->id),
            'Friend' => $this->chat->getFriend($request->user()->id),
        ]);
    }

    /**
     * Chat store
     *
     * @return \Illuminate\Http\RedirectResponse|void
    */
    public function store(Request $request, $receiverId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        if (empty($receiverId)) {
            return;
        }
        try {
            $message = $this->chat->sendMessage([
                'sender_id' => (int) $request->user()->id,
                'receiver_id' => (int) $receiverId,
                'message' => $request->message,
            ]);

            event(new MessageSent($message));

            return redirect()->route('chat.index', ['receiverId' => $receiverId])
                ->with('receiverId', $receiverId);
        } catch (\Throwable $th) {
            return redirect()->route('chat.index', ['receiverId' => $receiverId])
                ->with('receiverId', $receiverId);
        }
    }
}
