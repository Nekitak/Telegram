<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Telegram\Bot\Api;

use Illuminate\Support\Facades\DB; 

class BotClient extends Model
{
    /**
     * @var string token for up link
     */
    private string $_token;

    /**
    * @var string url for up webhook
    */
    private string $_webhookUrl;

    /**
     *  @var string status of webhook
     */
    private bool $_status = false;


    function __construct(string $token, string $webhookUrl = null, bool $autoEnableWebHook = false)
    {
        $this->_token = $token;
        $this->_webhookUrl = $webhookUrl;

        if($autoEnableWebHook){
            $this->enableWebhook();
        }
    }

    function __destruct ( )
    {
        if($this->_status){
            $this->disableWebhook(); 
        } 
    }

    public function enableWebhook( )
    { 
        $this->_status = true;

        return $this->sendTelegramData('setwebhook', [
            'query' => ['url' => $this->_webhookUrl . '/' . $this->_token]
        ]);   
    }

    public function disableWebhook()
    {
        $this->_status = false;
        return $this->sendTelegramData('setWebhook?remove'); 
    }

    public function getWebhookInfo()
    {
        return json_decode($this->sendTelegramData('getWebhookInfo'));
    }

    public function last(int $limit = 10)
    {
        return json_decode ( 
            $this->sendTelegramData("getUpdates" ,[
                'query' => ["limit" => $limit , "offset" => -$limit]
            ])
        );
    }

    public function sendTelegramData($route = '', $params = [], $method = 'POST')
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.telegram.org/bot' . $this->_token . '/']);
        $result = $client->request($method, $route, $params);
        return (string)$result->getBody();
    }
}
