@extends('layout_login')

@section('title_login')
Hộp Thư
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/message.css') }}">
@endsection

@section('content_login')
<div class="chat-container">
    <div class="chat-sidebar">
        <h3 class="chat-title">Cuộc trò chuyện</h3>
        <div class="search-box">
            <form action="{{ route('messages.index') }}" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Tìm kiếm người dùng..." value="{{ request('search') }}">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="chat-list">
            @forelse ($users as $user)
            <a href="{{ route('messages.index') }}?userId={{ $user->id }}{{ request('search') ? '&search=' . request('search') : '' }}" class="chat-item {{ ($userId ?? request()->query('userId')) == $user->id ? 'active' : '' }}">
                <img src="{{ $user->img ?? asset('uploads/default-avatar.jpg') }}" alt="Avatar" class="chat-avatar">
                <div class="chat-info">
                    <div class="chat-user">{{ $user->name }}</div>
                    <div class="chat-preview">
                        @php
                        $lastMessage = $user->receivedMessages->where('receiver_id', Auth::id())->sortByDesc('created_at')->first() ??
                                      $user->sentMessages->where('sender_id', Auth::id())->sortByDesc('created_at')->first();
                        @endphp
                        {{ $lastMessage ? substr($lastMessage->message, 0, 20) . '...' : 'Chưa có tin nhắn' }}
                    </div>
                    <div class="chat-time">
                        {{ $lastMessage ? $lastMessage->created_at->format('H:i') : '' }}
                    </div>
                </div>
            </a>
            @empty
            <p>Chưa có cuộc trò chuyện nào.</p>
            @endforelse
        </div>
    </div>

    <div class="chat-content">
        @if (request()->query('userId') && isset($chatData))
        @include('user.account.message', [
            'selectedUser' => $chatData['selectedUser'],
            'messages' => $chatData['messages']
        ])
        @else
        <div class="chat-placeholder">
            <p>Chọn một cuộc trò chuyện để bắt đầu.</p>
        </div>
        @endif
    </div>
</div>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentUserId = {{ Auth::id() }};
        const selectedUserId = {{ request()->query('userId') ? json_encode(request()->query('userId')) : 'null' }};
        if (window.Echo) {
            window.Echo.private(`chat.${currentUserId}`)
                .listen('MessageSent', (data) => {
                    if (data.receiver_id == currentUserId && data.sender_id == selectedUserId) {
                        let chatBox = document.querySelector('.chat-messages');
                        if (chatBox) {
                            let messageBubble = `
                                <div class="message-bubble received">
                                    <p>${data.message}</p>
                                    <span class="message-time">${new Date(data.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}</span>
                                </div>
                            `;
                            chatBox.innerHTML += messageBubble;
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }
                    }
                });
        } else {
            console.error('Echo is not initialized.');
        }
    });
</script>
@endsection