<?php
namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{
    /**
     * The name of the Telegram command.
     * Ex: help - Whenever the user sends /help, this would be resolved.
     *
     * @var string
     */
    protected $name = 'help';

    /**
     * Command Description
     *
     * @var string
     */
    protected $description = 'Illuminates your path';

    public function handle()
    {
        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => 'I will try to help you soon. Soonest!']);
    }
}
