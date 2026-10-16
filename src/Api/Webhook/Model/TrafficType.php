<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Traffic quality for "opened" and "clicked" statuses. "human" means a recognized browser or email client
 * without machine signs; "machine" means a bot, link scanner or security proxy; "protected" means a mailbox/OS
 * privacy proxy where a human action cannot be confirmed (Apple Mail Privacy Protection / iCloud Private Relay,
 * Gmail Image Proxy — Apple MPP is protected, not machine); "unknown" means the user agent is missing, broken or
 * not recognized.
 */
final class TrafficType
{
    public const HUMAN = 'human';
    public const MACHINE = 'machine';
    public const PROTECTED = 'protected';
    public const UNKNOWN = 'unknown';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::HUMAN,
            self::MACHINE,
            self::PROTECTED,
            self::UNKNOWN,
        ];
    }

    private function __construct()
    {
    }
}
