<?php declare(strict_types=1);

namespace Beeproger\Logging\RocketChatHandler\RocketChat;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use App\Logging\RocketChat\RocketChatRecord;
use GuzzleHttp\Client;

/**
 * Sends notifications through RocketChat Webhooks
 *
 * @author Martijn Wagena <martijn.wagena@beeproger.com>
 * @see    https://rocket.chat/docs/administrator-guides/integrations/
 */
class RocketChatWebhookHandler extends AbstractProcessingHandler
{
    /**
     * RocketChat Webhook token
     * @var string
     */
    private $webhookUrl;

    /**
     * Instance of the RocketChatRecord util class preparing data for RocketChat API.
     * @var RocketChatRecord
     */
    private $rocketChatRecord;

    /**
     * @param string      $webhookUrl             Rocket.Chat Webhook URL
     * @param string|null $channel                Rocket.Chat channel (encoded ID or name)
     * @param string|null $username               Name of a bot
     * @param bool        $useAttachment          Whether the message should be added to Rocket.Chat as attachment (plain text otherwise)
     * @param string|null $iconEmoji              The emoji name to use (or null)
     * @param bool        $useShortAttachment     Whether the the context/extra messages added to Rocket.Chat as attachments are in a short style
     * @param bool        $includeContextAndExtra Whether the attachment should include context and extra data
     * @param string|int  $level                  The minimum logging level at which this handler will be triggered
     * @param bool        $bubble                 Whether the messages that are handled can bubble up the stack or not
     * @param array       $excludeFields          Dot separated list of fields to exclude from Rocket.Chat message. E.g. ['context.field1', 'extra.field2']
     */
    public function __construct(
        string $webhookUrl,
        ?string $channel = null,
        ?string $username = null,
        bool $useAttachment = true,
        ?string $iconEmoji = null,
        bool $useShortAttachment = false,
        bool $includeContextAndExtra = false,
        $level = Logger::CRITICAL,
        bool $bubble = true,
        array $excludeFields = array()
    ) {
        parent::__construct($level, $bubble);

        $this->webhookUrl = $webhookUrl;

        $this->rocketChatRecord = new RocketChatRecord(
            $channel,
            $username,
            $useAttachment,
            $iconEmoji,
            $useShortAttachment,
            $includeContextAndExtra,
            $excludeFields
        );

    }

    public function getRocketChatRecord(): RocketChatRecord
    {
        return $this->rocketChatRecord;
    }

    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record): void
    {
        $postData = $this->rocketChatRecord->getRocketChatData($record);

        $client = new Client();
        $client->request('post', $this->webhookUrl, [
            'json' => $postData
        ]);
    }

    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        parent::setFormatter($formatter);
        $this->rocketChatRecord->setFormatter($formatter);

        return $this;
    }

    public function getFormatter(): FormatterInterface
    {
        $formatter = parent::getFormatter();
        $this->rocketChatRecord->setFormatter($formatter);

        return $formatter;
    }
}
