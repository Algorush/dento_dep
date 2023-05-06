<?php

namespace Webmagic\Dashboard\Elements\Widgets;

use Webmagic\Dashboard\Elements\StringElement;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget icon($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget iconBackgroundColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget title($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget message($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget description($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget backgroundColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget textColor($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget class($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget progress($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Widgets\Widget progressColor($valueOrConfig)
 *
 ********************************************************************************************************************/

class ProgressWidget extends Widget
{
    /** @var  StringElement Component view name */
    protected $view = 'dashboard::elements.widgets.progress_widget';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'title',
        'message',
        'description',
        'icon',
        'class',
        'progress',
        'icon_background_color',
        'background_color',
        'text_color',
        'progress_color'
    ];
}