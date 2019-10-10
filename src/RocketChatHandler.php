<?php

namespace Beeproger\Logging\RocketChatHandler;

use Beeproger\Logging\RocketChatHandler\RocketChat\RocketChatWebhookHandler;
use Illuminate\Log\ParsesLogConfiguration;
use Monolog\Logger;

class RocketChatHandler
{
    use ParsesLogConfiguration;

    public function __invoke(array $config)
    {
        $logger = new Logger('rocketchat');
        $logger->pushHandler(new RocketChatWebhookHandler(
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

    public function getFallbackChannelName() {
        return '@martijn.wagena';
    }
}
