<?php

declare(strict_types=1);

namespace UniOne\Api\Template\Model;

/**
 * Editor type, "html" or "visual". Default is "html". You can create a template with "visual" editor type only
 * in web interface.
 */
final class EditorType
{
    public const HTML = 'html';
    public const VISUAL = 'visual';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::HTML,
            self::VISUAL,
        ];
    }

    private function __construct()
    {
    }
}
