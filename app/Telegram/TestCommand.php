<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class TestCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'test';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['listcommands'];

    /**
     * @var string Command Description
     */
    protected $description = 'Test command, Get a list of commands';

    /**
     * {@inheritdoc}
     */
    public function handle( )
    {
        $this->replyWithChatAction(["action" => Actions::TYPING]);
 
        $user = \App\User::find(1);

        $this->replyWithMessage(['text' => "Почта пользователя в laravel: " . $user->email]);
        

    }
}
