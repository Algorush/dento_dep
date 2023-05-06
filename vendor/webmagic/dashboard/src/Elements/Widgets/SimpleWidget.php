<?php

namespace Webmagic\Dashboard\Elements\Widgets;

use Webmagic\Dashboard\Elements\StringElement;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget icon($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget iconColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget iconBackgroundColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget title($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget message($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget backgroundColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget class($valueOrConfig)
 *
 ********************************************************************************************************************/

class SimpleWidget extends Widget
{
    /** @var  StringElement Component view name */
    protected $view = 'dashboard::elements.widgets.simple_widget';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'title',
        'message',
        'icon',
        'class',
        'icon_background_color',
        'icon_color',
        'background_color',
        'text_color'
    ];
}