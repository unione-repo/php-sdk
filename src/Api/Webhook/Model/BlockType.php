<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Spam block type, either single or multiple sending SMTP. For single sending SMTP block in common pool UniOne
 * retries several other SMTPs. This property exists only if event_name="transactional_spam_block".
 */
enum BlockType: string
{
    case OneSmtp = 'one_smtp';
    case AllSmtp = 'all_smtp';
}
