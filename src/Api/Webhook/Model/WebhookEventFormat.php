<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Notification format. "json_post"(default) or "json_post_gzip".
 */
final class WebhookEventFormat
{
    public const JSON_POST = 'json_post';
    public const JSON_POST_GZIP = 'json_post_gzip';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::JSON_POST,
            self::JSON_POST_GZIP,
        ];
    }

    private function __construct()
    {
    }
}
