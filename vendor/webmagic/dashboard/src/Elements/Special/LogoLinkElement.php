<?php


namespace Webmagic\Dashboard\Elements\Special;

use Webmagic\Dashboard\Core\ComplexElement;

class LogoLinkElement extends ComplexElement
{
    protected $view = 'dashboard::elements.special.logo_link';

    protected $available_fields = [
        'link',
        'icon',
        'class',
        'prefer_image_logo',
        'regular_text',
        'collapsed_text'
    ];

    protected $default_field = 'text';
}
