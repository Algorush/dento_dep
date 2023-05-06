<?php

namespace Webmagic\Dashboard\Elements\Widgets;

use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Elements\StringElement;

abstract class Widget extends ComplexElement
{
    /** @var  StringElement Default section for current component */
    protected $default_field = 'title';
}