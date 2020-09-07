<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    /**
     * @param string $bot
     * @param string $token
     * @todo complete this method
     */
    public function webhook(string $bot, string $token)
    {
        $update = Telegram::commandsHandler(true);
        $response = Telegram::getMe();

        dd($update);

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        $chatId = $update->getMessage()->getChat()->getId();

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Hello',
        ]);
    }
}
