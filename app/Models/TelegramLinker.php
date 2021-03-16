<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BotInteractor;

use Illuminate\Support\Facades\DB; 

class TelegramLinker extends Model
{ 
    //int $telegramChatId, int $botId, int $phone
    // think, that here can be provide array instead of a set of variables
    public function linkUserWithBot(array $data)
    {
        // bot doesn`t exist
        if(DB::table("bots")->where("id", $data["botId"])->doesntExist() ) {
            return false;
        }

        // already linked
        if(
            DB::table("bot_users_relations")->where("telegram_chat_id", $data["telegramChatId"])->exists() and 
            DB::table("bots")->where("id", $data["botId"])->exists() 
        )  {
            return false;
        }

        DB::table("bot_users_relations")->insert([ 
            'bot_id' =>  $data["botId"],
            'telegram_chat_id' => $data["telegramChatId"],
            'phone' => $data["phone"]  
        ]); 
 
        return true;
    }
  
