<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Webhook status, "active" by default. "disabled" means that webhook has been disabled by the user, "stopped"
 * means that webhook has been stopped by the system after 24h of failed calls (with minimum of 10 distinct
 * events).
 */
final class WebhookStatus
{
    public const ACTIVE = 'active';
    public const DISABLED = 'disabled';
    public const STOPPED = 'stopped';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::ACTIVE,
            self::DISABLED,
            self::STOPPED,
        ];
    }

    private function __construct()
    {
    }
}
