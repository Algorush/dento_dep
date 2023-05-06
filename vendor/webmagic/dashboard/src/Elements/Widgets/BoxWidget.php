<?php

namespace Webmagic\Dashboard\Elements\Widgets;

use Webmagic\Dashboard\Elements\StringElement;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget icon($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget title($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget message($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget description($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget backgroundColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget textColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget class($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget link($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget linkTitle($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget linkIcon($valueOrConfig)
 *
 ********************************************************************************************************************/

class BoxWidget extends Widget
{
    /** @var  StringElement Component view name */
    protected $view = 'dashboard::elements.widgets.box_widget';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'title',
        'message',
        'description',
        'icon',
        'icon_color',
        'class',
        'background_color',
        'text_color',
        'link',
        'link_title',
        'link_icon',
    ];
}