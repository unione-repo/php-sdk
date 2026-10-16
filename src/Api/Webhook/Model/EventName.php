<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Type of event data contained in event_data field, either "transactional_email_status" or
 * "transactional_spam_block".
 */
enum EventName: string
{
    case TransactionalEmailStatus = 'transactional_email_status';
    case TransactionalSpamBlock = 'transactional_spam_block';
}
