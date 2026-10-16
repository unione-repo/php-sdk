<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Recipient's device type, detected from the user agent. Present for "clicked" and "opened" statuses; equals
 * "unknown" if the device type couldn't be detected.
 */
enum DeviceType: string
{
    case Desktop = 'desktop';
    case Mobile = 'mobile';
    case Tablet = 'tablet';
    case Other = 'other';
    case Unknown = 'unknown';
}
