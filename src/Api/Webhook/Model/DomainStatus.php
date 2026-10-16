<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Whether it's a block or unblock event. This property exists only if event_name="transactional_spam_block".
 */
enum DomainStatus: string
{
    case Blocked = 'blocked';
    case Unblocked = 'unblocked';
}
