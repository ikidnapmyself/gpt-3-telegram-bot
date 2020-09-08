<?php

namespace App\Http\Controllers;

use App\Services\GPT3Service;
use Illuminate\Support\Arr;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    /**
     * @var GPT3Service
     */
    public GPT3Service $gpt3;

    /**
     * TelegramController constructor.
     * @param GPT3Service $gpt3
     */
    public function __construct(GPT3Service $gpt3)
    {
        $this->gpt3 = $gpt3;
    }

    /**
     * @todo complete this method
     */
    public function webhook()
    {
        $update = Telegram::commandsHandler(true);

        $chatId = $update->getMessage()->getChat()->getId();

        if(optional($update->getMessage())->text) {
            $response = $this->gpt3->completion($update->getMessage()->text, [
                'max_tokens' => 25,
                'temperature' => 0.2,
                'n' => 1,
            ]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => Arr::get($response, 'choices.0.text')
            ]);
        }

        return 'ok';

    }
}
