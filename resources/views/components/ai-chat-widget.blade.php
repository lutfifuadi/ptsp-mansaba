<div id="ai-chat-widget" class="ai-chat-widget">
    <!-- Chat Button -->
    <button id="chat-toggle-btn" class="chat-toggle-btn">
        <i class="ti ti-robot tabler-robot"></i>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" class="chat-window d-none">
        <div class="chat-header">
            <div class="header-info">
                <div class="ai-avatar">
                    <i class="ti ti-robot tabler-robot"></i>
                </div>
                <div class="ai-details">
                    <div class="ai-name">Asisten Pintar PTSP</div>
                    <div class="ai-status">
                        <span class="status-dot"></span> Online
                    </div>
                </div>
            </div>
            <button id="close-chat" class="close-btn">&times;</button>
        </div>
        
        <div id="chat-messages" class="chat-messages">
            <div class="message assistant">
                <div class="message-content">
                    Assalamu'alaikum! Saya <strong>Asisten Pintar PTSP</strong> MAN 1 Kota Bandung. Ada yang bisa saya bantu terkait layanan kami?
                </div>
                <span class="message-time">{{ date('H:i') }}</span>
            </div>
        </div>

        <div class="chat-input-area">
            <input type="text" id="chat-input" class="ai-input" placeholder="Ketik pesan..." autocomplete="off">
            <button id="send-btn" class="ai-send-btn">
                <i class="ti ti-send tabler-send"></i>
            </button>
        </div>
    </div>
</div>

<!-- Dependencies for AI Widget -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.ai-chat-widget {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    font-family: 'Public Sans', 'Plus Jakarta Sans', sans-serif;
}

.chat-toggle-btn {
    width: 60px;
    height: 60px;
    border-radius: 5px;
    background: #059669;
    color: white;
    border: none;
    box-shadow: 0 4px 20px rgba(5, 150, 105, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    font-size: 28px;
}

.chat-toggle-btn:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 6px 25px rgba(5, 150, 105, 0.6);
}

.chat-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 500px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border-radius: 5px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.5);
    animation: slideIn 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(30px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.chat-header {
    background: #059669;
    padding: 12px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ai-avatar {
    width: 42px;
    height: 42px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.ai-details .ai-name {
    font-weight: 700;
    font-size: 16px;
    line-height: 1.2;
}

.ai-details .ai-status {
    font-size: 11px;
    display: flex;
    align-items: center;
    gap: 6px;
    opacity: 0.9;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #4ade80;
    border-radius: 5px;
    display: inline-block;
    box-shadow: 0 0 10px #4ade80;
}

.close-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 5px;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    background: #f1f5f9;
}

.message {
    max-width: 85%;
    display: flex;
    flex-direction: column;
}

.message.user {
    align-self: flex-end;
}

.message.assistant {
    align-self: flex-start;
}

.message-content {
    padding: 12px 16px;
    border-radius: 5px;
    font-size: 14px;
    line-height: 1.6;
    white-space: pre-line;
}

.user .message-content {
    background: #059669;
    color: white;
    border-bottom-right-radius: 2px;
}

.assistant .message-content {
    background: white;
    color: #1e293b;
    border-bottom-left-radius: 2px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.message-time {
    font-size: 10px;
    color: #94a3b8;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.user .message-time {
    justify-content: flex-end;
}

.chat-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.ai-input {
    flex: 1;
    border: 1px solid #e2e8f0;
    padding: 12px 18px;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
    transition: all 0.2s;
    background: #f8fafc;
    color: #1e293b;
}

.ai-input:focus {
    border-color: #059669;
    background: white;
    box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
}

.ai-send-btn {
    width: 45px;
    height: 45px;
    border-radius: 5px;
    background: #059669;
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 20px;
}

.ai-send-btn:hover {
    background: #047857;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.typing-indicator {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: white;
    border-radius: 18px;
    width: fit-content;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 10px;
}

.dot {
    width: 7px;
    height: 7px;
    background: #94a3b8;
    border-radius: 50%;
    animation: blink 1.4s infinite both;
}

.dot:nth-child(2) { animation-delay: 0.2s; }
.dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes blink {
    0%, 80%, 100% { opacity: 0; }
    40% { opacity: 1; }
}

.d-none { display: none !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggleBtn = document.getElementById('chat-toggle-btn');
    const chatWindow = document.getElementById('chat-window');
    const closeChat = document.getElementById('close-chat');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const chatMessages = document.getElementById('chat-messages');

    let history = [];

    chatToggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('d-none');
        chatInput.focus();
    });

    closeChat.addEventListener('click', () => {
        chatWindow.classList.add('d-none');
    });

    const formatMessage = (text) => {
        if (!text) return '';
        // Convert *bold* to <b>
        text = text.replace(/\*(.*?)\*/g, '<strong>$1</strong>');
        // Convert _italic_ to <i>
        text = text.replace(/_(.*?)_/g, '<em>$1</em>');
        // Convert newlines to <br>
        text = text.replace(/\n/g, '<br>');
        return text;
    };

    const appendMessage = (role, content) => {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${role}`;
        
        let displayContent = content;
        let fillData = null;

        // Check for FILL_FORM action
        const fillFormRegex = /\[\[FILL_FORM: (.*?) \]\]/;
        const match = content.match(fillFormRegex);
        if (match) {
            try {
                fillData = JSON.parse(match[1]);
                displayContent = content.replace(fillFormRegex, '').trim();
            } catch (e) {
                console.error('Failed to parse fill data', e);
            }
        }

        msgDiv.innerHTML = `
            <div class="message-content">${formatMessage(displayContent)}</div>
            ${fillData ? `<button class="btn btn-sm btn-success mt-2 btn-fill-form" style="background:#059669; color:white; border:none; padding:5px 10px; border-radius:4px; font-size:12px; cursor:pointer;" data-fill='${JSON.stringify(fillData)}'><i class="ti ti-edit tabler-edit me-1"></i> Isi Form Otomatis</button>` : ''}
            <span class="message-time">${time} ${role === 'user' ? '<i class="ti ti-checks tabler-checks text-info" style="font-size: 14px"></i>' : ''}</span>
        `;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Add event listener for fill button
        if (fillData) {
            const btn = msgDiv.querySelector('.btn-fill-form');
            btn.addEventListener('click', function() {
                fillGuestBookForm(fillData);
            });
        }
    };

    const fillGuestBookForm = (data) => {
        const form = document.getElementById('guestBookForm');
        if (!form) {
            Swal.fire({
                icon: 'info',
                title: 'Form Tidak Ditemukan',
                text: 'Silakan buka halaman Buku Tamu terlebih dahulu untuk menggunakan fitur ini.',
                confirmButtonColor: '#059669'
            });
            return;
        }

        // Map data to fields
        for (const [key, value] of Object.entries(data)) {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) {
                if (input.tagName === 'SELECT') {
                    $(input).val(value).trigger('change');
                } else {
                    input.value = value;
                }
            }
        }

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data telah diisikan ke dalam formulir.',
            timer: 2000,
            showConfirmButton: false
        });
    };

    const showTyping = () => {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'message assistant';
        typingDiv.innerHTML = `
            <div class="typing-indicator">
                <div class="typing-dot" style="animation-delay: 0s"></div>
                <div class="typing-dot" style="animation-delay: 0.2s"></div>
                <div class="typing-dot" style="animation-delay: 0.4s"></div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return typingDiv;
    };

    const sendMessage = async () => {
        const text = chatInput.value.trim();
        if (!text) return;

        chatInput.value = '';
        appendMessage('user', text);
        
        const typingIndicator = showTyping();

        try {
            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    message: text,
                    history: history
                })
            });

            const data = await response.json();
            typingIndicator.remove();

            if (data.status === 'success') {
                appendMessage('assistant', data.reply);
                history.push({ role: 'user', content: text });
                history.push({ role: 'assistant', content: data.reply });
                // Limit history to last 10 messages
                if (history.length > 10) history = history.slice(-10);
            } else {
                appendMessage('assistant', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            }
        } catch (error) {
            typingIndicator.remove();
            appendMessage('assistant', 'Maaf, gagal terhubung ke server.');
        }
    };

    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
});
</script>
