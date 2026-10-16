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
enum ObsoleteUnsubscribedSetMessage: string
{
    case Unsubscribed = 'unsubscribed';
    case WasInactive = 'was inactive';
    case WasUnsubscribed = 'was unsubscribed';
    case AddedAndUnsubscribed = 'added and unsubscribed';
}
