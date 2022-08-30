<?php
namespace TgRedmine\helpers;

class Telegram
{
    public function getWebhookInfo()
    {
        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/getWebhookInfo');
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }

    public static function setWebhook()
    {
        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $params = [
            'url' => 'https://tg-red.testers-site.ru/' . $bot_token . '.php',
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/setWebhook');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_exec($curl);
        curl_close($curl);
    }

     public static function send($recipient, $text, $keyboard = false)
     {
         $config = Cfg::getInstance();
         $bot_token = $config->get('bot.token');
         $api_url = $config->get('bot.url');

         $params = [
             'disable_web_page_preview' => true,
             'chat_id' => $recipient,
             'text' => $text,
             'parse_mode' => 'HTML'
         ];
         // добавить к сообщению клавиатуру
         if($keyboard){
            $params['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard));
         } else {
             $params['reply_markup'] = json_encode([
                    'hide_keyboard' => true
                 ]);
         }

         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/sendMessage');
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_TIMEOUT, 10);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         $response = curl_exec($curl);
         curl_close($curl);

        Logger::getInstance()->log('send message ' . $recipient . ' ' . $text);
        Logger::getInstance()->log('send message response ' . $recipient . ' ' . json_encode($response));
        return json_decode($response, true);
     }

     public static function sendAnimation($recipient, $url)
     {
         $config = Cfg::getInstance();
         $bot_token = $config->get('bot.token');
         $api_url = $config->get('bot.url');

         $params = [
             'chat_id' => $recipient,
             'animation' => $url
         ];

         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/sendAnimation');
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_TIMEOUT, 10);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
         $foundGifs = curl_exec($curl);
         curl_close($curl);

        Logger::getInstance()->log('send gif ' . $recipient . ' ' . $url);


         return $foundGifs;
     }

    public static function sendPhoto($recipient, $url)
    {
        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $params = [
            'chat_id' => $recipient,
            'photo' => $url
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/sendPhoto');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $foundGifs = curl_exec($curl);
        curl_close($curl);

        Logger::getInstance()->log('send photo ' . $recipient . ' ' . $url);

        return $foundGifs;
    }

    public static function sendDocument($recipient, $url,$name='report.xlsx')
    {

        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/sendDocument');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);

        $cFile = curl_file_create($url, mime_content_type($url), $name);
    
        // Add CURLFile to CURL request
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            "document" => $cFile,
            'chat_id' => $recipient,

        ]);
        $foundGifs = curl_exec($curl);
        curl_close($curl);

        Logger::getInstance()->log('send doc ' . $recipient . ' ' . $url);


        return $foundGifs;
    }

    public static function sendVideo($recipient, $url)
    {
        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/sendVideo');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);

        $cFile = curl_file_create($url, 'video/mp4', 'stupid.mp4');
    
        // Add CURLFile to CURL request
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            "video" => $cFile,
            'chat_id' => $recipient,

        ]);
        $foundGifs = curl_exec($curl);
        curl_close($curl);
        Logger::getInstance()->log('send video ' . $recipient . ' ' . $url);
        Logger::getInstance()->log('send response ' . json_encode($foundGifs));

        return $foundGifs;
    }

    public static function sendDice($recipient)
    {
        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/sendDice');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'chat_id' => $recipient,
        ]);
        $foundGifs = curl_exec($curl);
        curl_close($curl);
        Logger::getInstance()->log('send response ' . json_encode($foundGifs));

        return $foundGifs;
    }

    public function setCommand($commands)
    {
        $config = Cfg::getInstance();
        $bot_token = $config->get('bot.token');
        $api_url = $config->get('bot.url');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url . $bot_token . '/setMyCommands');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'commands' => json_encode($commands),
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        Logger::getInstance()->log('set command ' . json_encode($response));
        var_dump($response);

        return $response;
    }
}