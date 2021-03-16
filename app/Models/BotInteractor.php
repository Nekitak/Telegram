<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Telegram\Bot\Api;

use Illuminate\Support\Facades\DB; 

class BotInteractor extends Model
{ 

    private $_token; 

    public function __construct(string $token = NULL)
    {
        $this->_token = $token; 
    }

    public function addBot(int $userId)
    { 

        $telegram = new Api($this->_token); 

        try {
            $response = $telegram->getMe();
        } catch (\Throwable $exception) {
            /**
             * in theory, here should be processing of exceptions
             */
            $exception->getMessage(); 
            return false;
        }
  
        // bot already added
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

    public function addQuestions(int $botId, array $qusetions)
    {
        if(DB::table("bots")->where("id", $botId)->doesntExist() ) {
            return false;
        }
 
        DB::table("questions")->insertOrIgnore( $qusetions ); 
  
        return true;
    }
  
    public function addAnswer(int $leadId, int $questionId, string $questionValue)
    { 
        if(
            DB::table("questions")->where("id", $questionId)->doesntExist() or
            DB::table("leads")->where("id", $leadId)->doesntExist()
        ) return false;
            
        DB::table("questions")->insert([ 
            'question_id' =>  $botId,
            'lead_id' => $qusetion,
            'value' => $questionValue 
        ]); 
 
        return true;
    }
 
}
