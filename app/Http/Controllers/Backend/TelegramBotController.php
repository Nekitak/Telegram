<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BotInteractor;
use App\Models\TelegramLinker;

class TelegramBotController extends Controller
{
    public function index( )
    {
         
    }

    public function uploadBot(array $botInfo)
    {
        $result = (new BotInteractor($botInfo["token"]))->addBot((int)$botInfo["userId"]); 
    }

    public function uploadQuestions(array $request)
    {
        $result = (new BotInteractor())->addQuestions($request);
    }

    public function linkUser(array $request)
    {
        $result = (new TelegramLinker())->linkUserWithBot($request);
    }
}
