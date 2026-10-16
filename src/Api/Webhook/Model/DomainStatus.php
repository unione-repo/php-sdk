<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Whether it's a block or unblock event. This property exists only if event_name="transactional_spam_block".
 */
final class DomainStatus
{
    public const BLOCKED = 'blocked';
    public const UNBLOCKED = 'unblocked';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::BLOCKED,
            self::UNBLOCKED,
        ];
    }

    private function __construct()
    {
    }
}
