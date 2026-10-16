<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

/**
 * Only domains with "active" DKIM record are allowed as sender domains.
 */
enum DkimStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
