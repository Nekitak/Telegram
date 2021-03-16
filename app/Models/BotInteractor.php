<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Telegram\Bot\Api;

use Illuminate\Support\Facades\DB; 

class BotInteractor extends Model
{
    use HasFactory;

    public function addBot(string $token, int $userId)
    {
        $telegram = new Api($token); 

        try {
            $response = $telegram->getMe();
        } catch (\Throwable $exception) {
            /**
             * hande exception
             */
            $exception->getMessage(); 
            return false;
        }
         
        if(DB::table("bots")->where("access_token", $token)->exists() ) {
           return false;
        }
        
        DB::table("bots")->insert([ 
            'name' => $response->getFirstName(),
            'access_token' => $token,
            'user_id' => $userId 
        ]); 

        return true;
    }

    public function addQuestion(int $botId, string $qusetion)
    {
        if(DB::table("bots")->where("id", $botId)->doesntExist() ) {
            return false;
        }

        DB::table("questions")->insert([ 
            'bot_id' =>  $botId,
            'question' => $qusetion  
        ]); 
  
        return true;
    }
}
