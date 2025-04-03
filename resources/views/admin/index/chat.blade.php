@extends('layout_admin')

@section('title_admin', 'Chat Hỗ Trợ')

@section('css_admin')
<link rel="stylesheet" href="{{ asset('assets/admin_css/chat.css') }}">
@endsection

@section('content_admin')
<div class="chat-container">
    <div class="chat-sidebar">
        <h3 class="chat-title">Danh sách người dùng</h3>
        <div class="search-box">
            <form action="{{ route('admin.chat.index') }}" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Tìm kiếm người dùng..." value="{{ request('search') }}">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="chat-list">
            @forelse ($users as $user)
            <a href="{{ route('admin.chat.index') }}?userId={{ $user->id }}{{ request('search') ? '&search=' . request('search') : '' }}" class="chat-item {{ $userId == $user->id ? 'active' : '' }}">
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
            <p>Chưa có người dùng nào nhắn tin.</p>
            @endforelse
        </div>
    </div>

    <div class="chat-content">
        @if ($userId && isset($chatData))
        <div class="chat-header">
            <img src="{{ $chatData['selectedUser']->img ?? asset('uploads/default-avatar.jpg') }}" alt="Avatar" class="chat-avatar">
            <div class="chat-user-info">
                <h4>{{ $chatData['selectedUser']->name }}</h4>
            </div>
        </div>
        <div class="chat-messages" id="chat-messages">
            @forelse ($chatData['messages'] as $message)
            <div class="message-bubble {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                <p>{{ $message->message }}</p>
                <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
            </div>
            @empty
            <p>Chưa có tin nhắn trong cuộc trò chuyện này.</p>
            @endforelse
        </div>
        <form id="chat-form" class="chat-input-form">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $chatData['selectedUser']->id }}">
            <div class="input-group">
                <textarea name="message" rows="1" class="chat-input" placeholder="Nhập tin nhắn..."></textarea>
                <button type="submit" class="send-btn">Gửi</button>
            </div>
        </form>
        @else
        <div class="chat-placeholder">
            <p>Chọn một người dùng để bắt đầu trò chuyện.</p>
        </div>
        @endif
    </div>
</div>

@vite(['resources/js/app.js'])
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

        const chatForm = document.getElementById('chat-form');
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                fetch('{{ route("admin.chat.send") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const messageBubble = `
                            <div class="message-bubble sent">
                                <p>${data.message}</p>
                                <span class="message-time">${new Date(data.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}</span>
                            </div>`;
                            chatMessages.insertAdjacentHTML('beforeend', messageBubble);
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                            form.querySelector('textarea').value = '';
                        } else {
                            alert('Có lỗi khi gửi tin nhắn: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi gửi tin nhắn.');
                    });
            });
        }

        if (window.Echo) {
            window.Echo.private(`chat.{{{ Auth::id() }}}`)
                .listen('MessageSent', (data) => {
                    const selectedUserId = '{{ $userId ?? "" }}';
                    if (data.sender_id == selectedUserId && data.receiver_id == '{{ Auth::id() }}') {
                        const messageBubble = `
                            <div class="message-bubble received">
                                <p>${data.message}</p>
                                <span class="message-time">${new Date(data.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}</span>
                            </div>`;
                        chatMessages.insertAdjacentHTML('beforeend', messageBubble);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                });
        } else {
            console.error('Echo is not initialized.');
        }
    });
</script>
@endsection