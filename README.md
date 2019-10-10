# Rocket.Chat Monolog Handler
A Monolog Rocket.Chat Handler meant for Laravel projects. 
It uses the same logic as the SlackWebhookHandler, available by default in the monolog package.  

## Install
```bash
composer require beeproger/rocketchat-monolog-handler
```

## Usage
Add the following line to the imports part of logging.php  
```php
use Beeproger\Logging\RocketChatHandler;
```
Add the following code to channels in logging.php in the config folder.  
```php
    'rocketchat' => [
        'driver' => 'custom',
        'via' => RocketChatHandler::class,
        'url' => env('LOG_ROCKETCHAT_WEBHOOK_URL', ''),
        'channel' => env('LOG_ROCKETCHAT_CHANNEL', ''),
    ],
```
update the 'stack' channel from:
```php
'channels'          => ['daily'],
```
to 
```php
'channels'          => ['daily', 'rocketchat'],
```


Add the following to your .env file:

```
LOG_ROCKETCHAT_WEBHOOK_URL=
LOG_ROCKETCHAT_CHANNEL=
```

And done!

-----
FAQ:

- [How to create a webhook](https://rocket.chat/docs/administrator-guides/integrations/).
- When using spaces in channel names like: 'This Channel' make sure to use the lowecase, kebab variant: 'this-channel' in the 'channel' value in your configuration.


## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
