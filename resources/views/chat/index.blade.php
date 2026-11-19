@extends('layouts.app')

@section('title', 'Чат поддержки — BookMarket')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/support-chat.css') }}">
@endpush

@section('content')
<section class="support-chat">
    <div class="container">
        <h1>Чат службы поддержки</h1>
        <p>Общайтесь с другими участниками в реальном времени.</p>

        <div class="chat-container">

            <header class="chat-header">
                <h2>Общий чат</h2>
                <span id="chatStatus" class="chat-status">
                    Не подключён
                </span>
            </header>

            <div class="chat-join" id="chatJoin">
                <label for="chatName">Ваше имя</label>
                <input type="text" id="chatName"
                       maxlength="30"
                       placeholder="Введите имя">
                <button type="button" id="joinButton">
                    Подключиться
                </button>
            </div>

            <div id="chatMessages"
                 class="chat-messages"
                 aria-live="polite"></div>

            <div id="typingIndicator"
                 class="typing-indicator"></div>

            <form id="chatForm" class="chat-input">
                <input type="text"
                       id="messageInput"
                       placeholder="Введите сообщение..."
                       maxlength="2000"
                       disabled>

                <button type="submit"
                        id="sendButton"
                        disabled>
                    Отправить
                </button>
            </form>
        </div>
    </div>
</section>
@endsection