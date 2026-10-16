<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Spam block type, either single or multiple sending SMTP. For single sending SMTP block in common pool UniOne
 * retries several other SMTPs. This property exists only if event_name="transactional_spam_block".
 */
final class BlockType
{
    public const ONE_SMTP = 'one_smtp';
    public const ALL_SMTP = 'all_smtp';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::ONE_SMTP,
            self::ALL_SMTP,
        ];
    }

    private function __construct()
    {
    }
}
