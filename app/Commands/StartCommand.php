<?php
namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * The name of the Telegram command.
     * Ex: start - Whenever the user sends /start, this would be resolved.
     *
     * @var string
     */
    protected $name = 'start';

    /**
     * Command Description
     *
     * @var string
     */
    protected $description = "Start Command to get you started";

    /**
     * Command Aliases - Helpful when you want to trigger command with more than one name.
     *
     * @var string[]
     */
    protected $aliases = ['welcome', 'hello'];

    public function handle()
    {
        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => 'Hello! Here are my available commands:']);

        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
        $commands = $this->getTelegram()->getCommands();

        // Build the list
        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        // Reply with the commands list
        $this->replyWithMessage(['text' => $response]);
    }
}
