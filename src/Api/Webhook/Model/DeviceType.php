<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Recipient's device type, detected from the user agent. Present for "clicked" and "opened" statuses; equals
 * "unknown" if the device type couldn't be detected.
 */
final class DeviceType
{
    public const DESKTOP = 'desktop';
    public const MOBILE = 'mobile';
    public const TABLET = 'tablet';
    public const OTHER = 'other';
    public const UNKNOWN = 'unknown';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::DESKTOP,
            self::MOBILE,
            self::TABLET,
            self::OTHER,
            self::UNKNOWN,
        ];
    }

    private function __construct()
    {
    }
}
