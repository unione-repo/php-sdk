<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Type of event data contained in event_data field, either "transactional_email_status" or
 * "transactional_spam_block".
 */
final class EventName
{
    public const TRANSACTIONAL_EMAIL_STATUS = 'transactional_email_status';
    public const TRANSACTIONAL_SPAM_BLOCK = 'transactional_spam_block';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::TRANSACTIONAL_EMAIL_STATUS,
            self::TRANSACTIONAL_SPAM_BLOCK,
        ];
    }

    private function __construct()
    {
    }
}
