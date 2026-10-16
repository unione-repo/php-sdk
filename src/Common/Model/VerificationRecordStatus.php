<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

/**
 * Only domains with "confirmed" verification record are allowed as sender domains.
 */
final class VerificationRecordStatus
{
    public const CONFIRMED = 'confirmed';
    public const UNCONFIRMED = 'unconfirmed';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::CONFIRMED,
            self::UNCONFIRMED,
        ];
    }

    private function __construct()
    {
    }
}
