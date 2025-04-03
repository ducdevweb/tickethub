
<div class="chat-header">
    <img src="{{ $selectedUser->img ?? asset('uploads/default-avatar.jpg') }}" alt="Avatar" class="chat-avatar">
    <div class="chat-user-info">
        <h4>{{ $selectedUser->name }}</h4>
    </div>
</div>

<div class="chat-messages">
    @forelse ($messages as $message)
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
    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
    <div class="input-group">
        <textarea name="message" rows="1" class="chat-input" placeholder="Nhập tin nhắn..."></textarea>
        <button type="submit" class="send-btn">Gửi</button>
    </div>
</form>

<script>
    document.getElementById('chat-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route('messages.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const chatBox = document.querySelector('.chat-messages');
                const messageBubble = `
                    <div class="message-bubble sent">
                        <p>${data.message}</p>
                        <span class="message-time">${new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}</span>
                    </div>
                `;
                chatBox.innerHTML += messageBubble;
                chatBox.scrollTop = chatBox.scrollHeight;
                form.reset();
            } else {
                alert('Có lỗi khi gửi tin nhắn: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi gửi tin nhắn.');
        });
    });
</script>