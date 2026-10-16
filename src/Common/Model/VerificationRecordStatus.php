<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

/**
 * Only domains with "confirmed" verification record are allowed as sender domains.
 */
enum VerificationRecordStatus: string
{
    case Confirmed = 'confirmed';
    case Unconfirmed = 'unconfirmed';
}
