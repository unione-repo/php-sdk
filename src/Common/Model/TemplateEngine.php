<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

/**
 * The [template engine](https://docs.unione.io/en/template-engines) for handling the substitutions(merge tags),
 * "simple", "velocity", "liquid" or "none". Default value is "simple".
 */
enum TemplateEngine: string
{
    case Simple = 'simple';
    case Velocity = 'velocity';
    case Liquid = 'liquid';
    case None = 'none';
}
