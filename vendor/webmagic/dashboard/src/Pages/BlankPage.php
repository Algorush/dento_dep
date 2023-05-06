<?php


namespace Webmagic\Dashboard\Pages;


/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method BlankPage data($valueOrConfig)
 * @method BlankPage addData($valueOrConfig)
 * @method BlankPage title($valueOrConfig)
 * @method BlankPage class($valueOrConfig)
 *
 ********************************************************************************************************************/

class BlankPage extends Page
{
    /** @var string  */
    protected $view = 'dashboard::pages.blank_page';

    protected $available_fields = [
	    'data',
        'title',
        'class',
    ];

    protected $default_field = 'data';
}
