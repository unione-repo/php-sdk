<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

/**
 * The [template engine](https://docs.unione.io/en/template-engines) for handling the substitutions(merge tags),
 * "simple", "velocity", "liquid" or "none". Default value is "simple".
 */
final class TemplateEngine
{
    public const SIMPLE = 'simple';
    public const VELOCITY = 'velocity';
    public const LIQUID = 'liquid';
    public const NONE = 'none';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::SIMPLE,
            self::VELOCITY,
            self::LIQUID,
            self::NONE,
        ];
    }

    private function __construct()
    {
    }
}
