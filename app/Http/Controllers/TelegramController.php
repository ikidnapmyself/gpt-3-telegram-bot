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
        $updates = Telegram::getWebhookUpdates();
        $response = Telegram::getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        dd($botId, $firstName, $username, $updates);
    }
}
