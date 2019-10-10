<?php

namespace Beeproger\Logging;

use Monolog\Logger;
use Illuminate\Log\ParsesLogConfiguration;
use Monolog\Handler\SlackWebhookHandler;

class RocketChatHandler
{
    use ParsesLogConfiguration;

    public function __invoke(array $config)
    {
        $logger = new Logger('rocketchat');
        $logger->pushHandler(new SlackWebhookHandler(
            $config['url'],
            $config['channel'] ?? null,
            $config['username'] ?? 'Laravel',
            $config['attachment'] ?? true,
            $config['emoji'] ?? ':boom:',
            $config['short'] ?? false,
            $config['context'] ?? true,
            $this->level($config),
            $config['bubble'] ?? true,
            $config['exclude_fields'] ?? []
        ), $config);

        return $logger;
    }

    public function getFallbackChannelName()
    {
        return '#general';
    }
}
