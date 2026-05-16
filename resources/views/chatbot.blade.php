@extends('layouts.app')
@section('title', 'AI Animal Chatbot')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8 reveal">
            <h1 class="section-title">🤖 AI Animal Chatbot</h1>
            <p class="section-subtitle">Ask me anything about animals!</p>
        </div>

        {{-- Chat Container --}}
        <div class="glass-card overflow-hidden reveal">
            {{-- Suggestion Chips --}}
            <div class="p-4 border-b border-white/10">
                <p class="text-xs text-gray-500 mb-2">Try asking:</p>
                <div class="flex flex-wrap gap-2">
                    <button onclick="sendSuggestion('What do lions eat?')" class="text-xs bg-zoo-600/20 text-zoo-400 px-3 py-1.5 rounded-full hover:bg-zoo-600/40 transition-colors">What do lions eat?</button>
                    <button onclick="sendSuggestion('Tell me about tigers')" class="text-xs bg-zoo-600/20 text-zoo-400 px-3 py-1.5 rounded-full hover:bg-zoo-600/40 transition-colors">Tell me about tigers</button>
                    <button onclick="sendSuggestion('Fun facts about elephants')" class="text-xs bg-zoo-600/20 text-zoo-400 px-3 py-1.5 rounded-full hover:bg-zoo-600/40 transition-colors">Fun facts about elephants</button>
                    <button onclick="sendSuggestion('Is the panda endangered?')" class="text-xs bg-zoo-600/20 text-zoo-400 px-3 py-1.5 rounded-full hover:bg-zoo-600/40 transition-colors">Is the panda endangered?</button>
                    <button onclick="sendSuggestion('Where do penguins live?')" class="text-xs bg-zoo-600/20 text-zoo-400 px-3 py-1.5 rounded-full hover:bg-zoo-600/40 transition-colors">Where do penguins live?</button>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div id="chatMessages" class="h-[500px] overflow-y-auto p-6 space-y-4">
                {{-- Welcome message --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-zoo-600/50 rounded-full flex items-center justify-center text-sm shrink-0">🤖</div>
                    <div class="chat-bubble-bot">
                        <p>👋 <strong>Welcome to ZooSphere AI!</strong></p>
                        <p class="mt-2 text-sm text-gray-300">I know everything about our zoo animals. Ask me about their diet, habitat, fun facts, conservation status, or anything else!</p>
                    </div>
                </div>
            </div>

            {{-- Input Area --}}
            <div class="p-4 border-t border-white/10">
                <form id="chatForm" onsubmit="sendMessage(event)" class="flex gap-3">
                    <input type="text" id="chatInput" placeholder="Ask about any animal..."
                           class="form-input flex-1 px-4 py-3" autocomplete="off" maxlength="500">
                    <button type="submit" class="btn-primary px-6 py-3" id="sendBtn">
                        <span id="sendText">Send</span>
                        <span id="sendSpinner" class="hidden spinner inline-block"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');

    // Check for pre-filled question from URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('ask')) {
        chatInput.value = 'Tell me about ' + urlParams.get('ask');
        setTimeout(() => sendMessage(new Event('submit')), 500);
    }

    function sendSuggestion(text) {
        chatInput.value = text;
        sendMessage(new Event('submit'));
    }

    function sendMessage(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        chatInput.value = '';

        // Show typing indicator
        const typingId = 'typing-' + Date.now();
        chatMessages.innerHTML += `
            <div class="flex items-start gap-3" id="${typingId}">
                <div class="w-8 h-8 bg-zoo-600/50 rounded-full flex items-center justify-center text-sm shrink-0">🤖</div>
                <div class="chat-bubble-bot">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-zoo-400 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                        <span class="w-2 h-2 bg-zoo-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-zoo-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>`;
        scrollToBottom();

        // Send to backend
        fetch('{{ route("chatbot.ask") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById(typingId)?.remove();
            addMessage(data.response, 'bot');
        })
        .catch(err => {
            document.getElementById(typingId)?.remove();
            addMessage('Sorry, I had trouble processing that. Please try again!', 'bot');
        });
    }

    function addMessage(text, type) {
        // Convert markdown-like bold to HTML
        const formattedText = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');

        if (type === 'user') {
            chatMessages.innerHTML += `
                <div class="flex justify-end">
                    <div class="chat-bubble-user">${formattedText}</div>
                </div>`;
        } else {
            chatMessages.innerHTML += `
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-zoo-600/50 rounded-full flex items-center justify-center text-sm shrink-0">🤖</div>
                    <div class="chat-bubble-bot">${formattedText}</div>
                </div>`;
        }
        scrollToBottom();
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
</script>
@endpush
