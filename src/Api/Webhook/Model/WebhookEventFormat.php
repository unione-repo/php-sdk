<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

/**
 * Notification format. "json_post"(default) or "json_post_gzip".
 */
enum WebhookEventFormat: string
{
    case JsonPost = 'json_post';
    case JsonPostGzip = 'json_post_gzip';
}
