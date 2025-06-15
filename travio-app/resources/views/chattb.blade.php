<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Travio | Chats</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.19.0/echo.iife.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-indigo-600 text-white p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-comments mr-2"></i> Chats
                </h1>
                <div class="relative">
                    <a href="{{ route('index') }}"
                        class="group inline-flex items-center hover:text-black transition-colors duration-300">
                        <span class="mr-2 font-medium">To the main page</span>
                        <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                    </a>
                </div>
                <div class="flex items-center space-x-4">

                    <div class="relative">
                        <input type="text" placeholder="Search chats..."
                            class="bg-indigo-500 text-white placeholder-indigo-200 rounded-full py-1 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <i class="fas fa-search absolute left-3 top-2 text-indigo-200"></i>
                    </div>

                    <div class="w-8 h-8 rounded-full bg-indigo-400 flex items-center justify-center cursor-pointer">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex flex-1 overflow-hidden">
            <!-- Sidebar - Chat List -->
            <aside class="w-80 bg-white border-r border-gray-200 flex flex-col">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-inbox mr-2 text-indigo-500"></i> My Chats
                    </h2>
                </div>
                <div class="flex-1 overflow-y-auto scrollbar-hide">
                    <ul id="chat-list" class="divide-y divide-gray-100">
                        @foreach ($chats as $chat)
                            <li class="chat-item p-4 hover:bg-gray-50 cursor-pointer transition-colors duration-200"
                                data-chat-id="{{ $chat->id }}">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user-friends text-indigo-500"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">{{ $chat->name ?? 'Chat ' . $chat->id }}
                                        </h3>
                                        <p class="text-sm text-gray-500 truncate">Last message preview...</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-4 border-t border-gray-200">
                    <button
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i> New Chat
                    </button>
                </div>
            </aside>

            <!-- Chat Area -->
            <section class="flex-1 flex flex-col bg-white">
                <!-- Chat Header -->
                <div id="chat-header" class="p-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                            <i class="fas fa-user-friends text-indigo-500"></i>
                        </div>
                        <div>
                            <h2 id="chat-title" class="font-semibold text-gray-800">Select a chat</h2>
                            <p class="text-xs text-gray-500">Online</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button
                            class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-phone text-gray-600"></i>
                        </button>
                        <button
                            class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-video text-gray-600"></i>
                        </button>
                        <button
                            class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-ellipsis-v text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Messages Container -->
                <div id="messages" class="flex-1 p-4 overflow-y-auto scrollbar-hide bg-gray-50">
                    <div class="max-w-3xl mx-auto">
                        <!-- Welcome message when no chat is selected -->
                        <div id="welcome-message"
                            class="h-full flex flex-col items-center justify-center text-center py-10">
                            <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-comments text-indigo-500 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Welcome to ChatApp</h3>
                            <p class="text-gray-500 max-w-md">Select a chat from the sidebar to start messaging or
                                create a new conversation.</p>
                        </div>
                    </div>
                </div>

                <!-- Message Input Form -->
                <div id="message-form" class="p-4 border-t border-gray-200 bg-white hidden">
                    <div class="max-w-3xl mx-auto">
                        <form class="flex items-center space-x-2">
                            <button type="button"
                                class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors duration-200">
                                <i class="fas fa-paperclip text-gray-500"></i>
                            </button>
                            <input type="text" id="message-input" placeholder="Type your message..."
                                class="flex-1 border border-gray-300 rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <button type="submit"
                                class="w-10 h-10 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center transition-colors duration-200">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ ENV('REVERB_APP_KEY') }}',
            wsHost: window.location.hostname,
            wsPort: {{ ENV('REVERB_PORT') }},
            wssPort: {{ ENV('REVERB_PORT') }},
            forceTLS: false,
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });

        let currentChatId = null;

        function openChat(chatId) {
            if (currentChatId) {
                window.Echo.leave('private-chat.' + currentChatId);
                document.querySelector(`.chat-item[data-chat-id="${currentChatId}"]`).classList.remove('active');
            }

            currentChatId = chatId;
            document.getElementById('chat-title').innerText = 'Chat ' + chatId;
            document.getElementById('messages').innerHTML = '';
            document.getElementById('message-form').classList.remove('hidden');

            document.querySelector(`.chat-item[data-chat-id="${chatId}"]`).classList.add('active');

            window.Echo.private('chat.' + chatId)
                .listen('MessageSent', (e) => {
                    const msgDiv = document.createElement('div');
                    msgDiv.className = 'chat-message mb-4';
                    msgDiv.innerHTML = `
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-indigo-500 text-xs"></i>
                            </div>
                            <div>
                                <div class="bg-white p-3 rounded-lg shadow-sm inline-block max-w-xs lg:max-w-md">
                                    <p class="font-medium text-gray-800">${e.user_name}</p>
                                    <p class="text-gray-700">${e.body}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Just now</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('messages').append(msgDiv);
                    document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
                });

            fetch('/chats/' + chatId + '/messages')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        const emptyMsg = document.createElement('div');
                        emptyMsg.className = 'text-center py-10 text-gray-500';
                        emptyMsg.textContent = 'No messages yet. Start the conversation!';
                        document.getElementById('messages').append(emptyMsg);
                    } else {
                        data.forEach(msg => {
                            const msgDiv = document.createElement('div');
                            msgDiv.className = 'chat-message mb-4';
                            msgDiv.innerHTML = `
                                <div class="flex items-start">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-indigo-500 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="bg-white p-3 rounded-lg shadow-sm inline-block max-w-xs lg:max-w-md">
                                            <p class="font-medium text-gray-800">${msg.user.name}</p>
                                            <p class="text-gray-700">${msg.body}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">${new Date(msg.created_at).toLocaleTimeString()}</p>
                                    </div>
                                </div>
                            `;
                            document.getElementById('messages').append(msgDiv);
                        });
                    }
                    document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
                });
        }

        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', () => {
                const chatId = item.getAttribute('data-chat-id');
                openChat(chatId);
            });
        });

        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const textInput = document.getElementById('message-input');
            const text = textInput.value.trim();
            if (!text) return;

            fetch('/chats/' + currentChatId + '/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    body: text
                })
            }).then(() => {
                textInput.value = '';
            });
        });
    </script>
</body>

</html>
