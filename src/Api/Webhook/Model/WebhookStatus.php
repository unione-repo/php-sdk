<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Webhook status, "active" by default. "disabled" means that webhook has been disabled by the user, "stopped"
 * means that webhook has been stopped by the system after 24h of failed calls (with minimum of 10 distinct
 * events).
 */
enum WebhookStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';
    case Stopped = 'stopped';
}
