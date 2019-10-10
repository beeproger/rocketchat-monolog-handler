# Rocket.Chat Monolog Handler
A Monolog Rocket.Chat Handler meant for Laravel projects. 
It uses the same logic as the SlackWebhookHandler, available by default in the monolog package.  

## Install
```bash
composer require beeproger/rocketchat-monolog-handler
```

## Usage
Add the following code to your logging.php in the config folder.  
```php
    'rocketchat' => [
        'driver' => 'custom',
        'via' => RocketChatHandler::class,
        'url' => env('LOG_ROCKETCHAT_WEBHOOK_URL', ''),
        'channel' => '#general',
    ],
```
Add the following line to the imports part of logging.php  
```
use Beeproger\Logging\RocketChatHandler;
```

add LOG_ROCKETCHAT_WEBHOOK_URL to your .env file.  
See [this link](https://rocket.chat/docs/administrator-guides/integrations/) to create a webhook.  

The username and channel config keys can be set to any channel and username you please.

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
