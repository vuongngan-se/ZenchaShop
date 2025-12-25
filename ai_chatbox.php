<!DOCTYPE html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Zencha AI Chatbot</title>
    
    <style>
#chat-container, #chat-toggle-button {
    position: fixed; 
    bottom: 20px;    
    right: 20px;     
    z-index: 1000;   
}

#chat-container {
    width: 350px;
    height: 450px;
    border: 1px solid #D7CCC8; 
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    display: flex; 
    flex-direction: column;
    transition: all 0.3s ease-in-out; 
    background-color: #FAFAFA;
}

/* Lớp CSS để ẩn chatbox */
.hidden {
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
}

/* Định kiểu cho nút Icon (Toggle Button) */
#chat-toggle-button {
    background-color: #8BC34A; 
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 30px; 
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    font-size: 16px;
    font-weight: bold;
}
#chat-header {
    background-color: #795548; 
    color: white;
    padding: 10px;
    font-size: 1.1em;
    text-align: center;
    flex-shrink: 0; 
}

#chat-messages {
    flex-grow: 1;
    padding: 10px;
    overflow-y: auto;
    background-color: #F5F5DC; 
    flex-basis: auto; 
    display: flex; 
    flex-direction: column;
}
.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 15px;
    max-width: 80%;
}

.user-message {
    background-color: #DCE775; 
    align-self: flex-end;
    margin-left: auto;
}

.ai-message {
    background-color: #FFF8E1; 
    border: 1px solid #E0E0E0;
    align-self: flex-start;
}

#chat-input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid #D7CCC8; 
}

#user-input {
    flex-grow: 1;
    padding: 8px;
    border: 1px solid #BDBDBD; 
    border-radius: 4px;
    margin-right: 10px;
}

#send-button {
    background-color: #8BC34A; 
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
}
</style>
</head>
<body>
<button id="chat-toggle-button">
    💬 Chat Zencha
</button>
<div id="chat-container" class="hidden"> 
    <div id="chat-header">
        Zencha AI Chatbot
        <span id="close-button" style="float: right; cursor: pointer;">&times;</span>
    </div>
    <div id="chat-messages">
        <div class="message ai-message">Chào mừng bạn đến với ZenCha của chúng tôi. Tôi có thể giúp gì cho bạn!</div>
    </div>
    <div id="chat-input-area">
        <input type="text" id="user-input" placeholder="Nhập câu hỏi của bạn...">
        <button id="send-button">Gửi</button>
    </div>
</div>

<script>
    const chatMessages = document.getElementById('chat-messages');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');
    // KHAI BÁO MỚI
    const chatContainer = document.getElementById('chat-container');
    const chatToggleButton = document.getElementById('chat-toggle-button');
    const closeButton = document.getElementById('close-button'); 

    // HÀM BẬT/TẮT CHATBOX
    function toggleChat() {
        chatContainer.classList.toggle('hidden');
        // Tùy chỉnh icon/text
        if (chatContainer.classList.contains('hidden')) {
            chatToggleButton.innerHTML = '💬 Chat Zencha';
            chatToggleButton.style.display = 'block'; // Hiển thị nút Icon
        } else {
            chatToggleButton.style.display = 'none'; // Ẩn nút Icon khi Chatbox hiện
        }
    }
    
    // GẮN SỰ KIỆN BẬT/TẮT
    chatToggleButton.addEventListener('click', toggleChat);
    closeButton.addEventListener('click', toggleChat);
    function appendMessage(sender, text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ' + (sender === 'user' ? 'user-message' : 'ai-message');
        messageDiv.innerText = text;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight; 
    }

    async function sendMessage() {
        const message = userInput.value.trim();
        if (message === '') return;

        appendMessage('user', message);
        userInput.value = '';
        sendButton.disabled = true;

        try {
            const response = await fetch('ai_chatbox_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ prompt: message })
            });

            const data = await response.json();

            if (data.error) {
                appendMessage('ai', 'Lỗi: ' + data.error);
            } else if (data.response) {
                appendMessage('ai', data.response);
            } else {
                appendMessage('ai', 'Không nhận được phản hồi từ AI.');
            }

        } catch (error) {
            appendMessage('ai', 'Lỗi kết nối: Không thể gửi yêu cầu đến máy chủ.');
            console.error('Fetch error:', error);
        } finally {
            sendButton.disabled = false;
        }
    }

    sendButton.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

appendMessage('user', message);
userInput.value = '';
sendButton.disabled = true;

// 1. THÊM TRẠNG THÁI LOADING
const loadingMessageId = 'loading-' + Date.now();
appendMessage('ai', 'Zencha đang soạn trà, xin chờ chút...'); 
const loadingDiv = chatMessages.lastElementChild;
loadingDiv.id = loadingMessageId;

try {

    // 2. XÓA TIN NHẮN LOADING TRƯỚC KHI HIỂN THỊ KẾT QUẢ
    document.getElementById(loadingMessageId).remove(); 

    if (data.error) {
        appendMessage('ai', 'Lỗi: ' + data.error);
    } else if (data.response) {
        appendMessage('ai', data.response);
    } else {
        appendMessage('ai', 'Không nhận được phản hồi từ AI.');
    }

} catch (error) {
    // 3. XÓA TIN NHẮN LOADING KHI CÓ LỖI KẾT NỐI
    document.getElementById(loadingMessageId).remove(); 
    appendMessage('ai', 'Lỗi kết nối: Không thể gửi yêu cầu đến máy chủ.');
    console.error('Fetch error:', error);
} finally {
    sendButton.disabled = false;
}
</script>

</body>
</html>
