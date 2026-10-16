<?php

declare(strict_types=1);

namespace UniOne\Api\Template\Model;

/**
 * Editor type, "html" or "visual". Default is "html". You can create a template with "visual" editor type only
 * in web interface.
 */
enum EditorType: string
{
    case Html = 'html';
    case Visual = 'visual';
}
