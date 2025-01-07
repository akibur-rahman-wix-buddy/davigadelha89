{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <script>
        addEventListener('DOMContentLoaded', () => {
            Echo.private('chat.' + {{ auth()->user()->id }}).listen('MessageSent', (e) => {
                console.log(e);
            })
        })
    </script>
</body>

</html> --}}











{{-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="chat-box" style="height: 400px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;"></div>

    <form id="chat-form">
        <input type="hidden" id="receiver-id" value="2">
        <input type="text" id="message-input" placeholder="Type your message">
        <button type="submit">Send</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Echo.private('chat.' + {{ auth()->user()->id }})
                .listen('MessageSent', (e) => {
                    const chatBox = document.getElementById('chat-box');
                    const messageElement = document.createElement('div');
                    messageElement.className = 'message';
                    messageElement.innerText = e.message.text;
                    chatBox.appendChild(messageElement);
                });

            document.getElementById('chat-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const receiverId = document.getElementById('receiver-id').value;
                const message = document.getElementById('message-input').value;

                fetch('{{ route('send-message') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('message-input').value = '';
                    });
            });
        });
    </script>
</body>

</html> --}}











@extends('backend.app')

@section('title', 'Chat')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@push('styles')
    <style>
        #chat-box {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        .message {
            padding: 8px 12px;
            margin: 5px 0;
            border-radius: 20px;
            display: inline-block;
            max-width: 70%;
        }

        .sender {
            background-color: #0084ff;
            color: white;
            align-self: flex-end;
        }

        .receiver {
            background-color: #e4e6eb;
            color: black;
            align-self: flex-start;
        }

        .message-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }

        .receiver .message-container {
            justify-content: flex-start;
        }

        #message-input {
            width: 80%;
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #59c7fa;
            margin-right: 10px;
            background-color: #020101;
            /* off-white background */
            color: #4bf14b;
            /* light green text color */
            font-weight: bold;
            /* bold text */
        }

        #chat-form button {
            padding: 10px 20px;
            border-radius: 4px;
            background-color: #0084ff;
            color: white;
            border: none;
            cursor: pointer;
        }

        #chat-form button:hover {
            background-color: #006bbf;
        }
    </style>


    
@endpush

@section('content')
    <div id="chat-box">
        @foreach ($messages as $msg)
            <div class="message {{ $msg->sender_id == auth()->id() ? 'sent' : 'received' }}">
                <p>{{ $msg->text }}</p>
            </div>
        @endforeach
    </div>

    <form id="chat-form">
        <input type="hidden" id="receiver-id" value="{{ $receiver_id }}">
        <input type="text" id="message-input" placeholder="Type your message" required>
        <button type="submit">Send</button>
    </form>






@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Echo.private('chat.' + {{ auth()->user()->id }})
                .listen('MessageSent', (e) => {
                    appendMessage(e.message, e.message.sender_id === {{ auth()->user()->id }});
                });

            document.getElementById('chat-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const receiverId = document.getElementById('receiver-id').value;
                const message = document.getElementById('message-input').value;

                fetch('{{ route('send-message') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('message-input').value = '';
                        appendMessage(data, true);
                    });
            });

            function appendMessage(message, isSender) {
                const chatBox = document.getElementById('chat-box');
                const messageContainer = document.createElement('div');
                messageContainer.className = 'message-container ' + (isSender ? 'sender' : 'receiver');

                const messageElement = document.createElement('div');
                messageElement.className = 'message';
                messageElement.innerText = message.text;

                messageContainer.appendChild(messageElement);
                chatBox.appendChild(messageContainer);
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>

    <script>
        const form = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const chatBox = document.getElementById('chat-box');
        const receiverId = document.getElementById('receiver-id').value;

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const messageText = messageInput.value.trim();

            if (messageText) {
                // Ajax request to send the message
                fetch('{{ route('send-message') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: messageText,
                            receiver_id: receiverId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update the chat box with the new message
                        const message = document.createElement('div');
                        message.classList.add('message', 'sent');
                        message.innerHTML = `<p>${data.text}</p>`;
                        chatBox.appendChild(message);
                        messageInput.value = ''; // Clear the input field
                    });
            }
        });
    </script>

   
@endpush
