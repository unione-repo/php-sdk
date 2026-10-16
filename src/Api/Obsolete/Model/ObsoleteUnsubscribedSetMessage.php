<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

/**
 * Unsubscription process details:
 *
 * - "unsubscribed" if email has just been unsubscribed,
 * - "was inactive" if it was inactive due some reason,
 * - "was unsubscribed" if it already was unsubscribed before the call,
 * - "added and unsubscribed" if it's a new email without status history and it was added and then unsubscribed immediately.
 */
final class ObsoleteUnsubscribedSetMessage
{
    public const UNSUBSCRIBED = 'unsubscribed';
    public const WAS_INACTIVE = 'was inactive';
    public const WAS_UNSUBSCRIBED = 'was unsubscribed';
    public const ADDED_AND_UNSUBSCRIBED = 'added and unsubscribed';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::UNSUBSCRIBED,
            self::WAS_INACTIVE,
            self::WAS_UNSUBSCRIBED,
            self::ADDED_AND_UNSUBSCRIBED,
        ];
    }

    private function __construct()
    {
    }
}
