<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB; 

class Leads extends Model
{
    public function create(int $botUserId)
    {
        // lead already maked
        if(DB::table("leads")->where("bot_user_id", $botUserId)->exists() ) {
            return false;
        }

        DB::table("leads")->insert([ 
            'bot_user_id' =>  $botUserId, 
            'crated_at' => now(),
            'updated_at' => now()    
        ]); 
  
        return true;
    }
}
