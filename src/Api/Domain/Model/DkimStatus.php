<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

/**
 * Only domains with "active" DKIM record are allowed as sender domains.
 */
final class DkimStatus
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
        ];
    }

    private function __construct()
    {
    }
}
