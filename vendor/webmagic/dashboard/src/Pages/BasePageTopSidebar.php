<?php


namespace Webmagic\Dashboard\Pages;

use Illuminate\Contracts\Container\BindingResolutionException;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\Notifications\Notification;
use Webmagic\Dashboard\NotificationService\NotificationService;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method BasePageTopSidebar headerLogo($valueOrConfig)
 * @method BasePageTopSidebar addHeaderLogo($valueOrConfig)
 * @method BasePageTopSidebar headerNav($valueOrConfig)
 * @method BasePageTopSidebar addHeaderNav($valueOrConfig)
 * @method BasePageTopSidebar mainSidebar($valueOrConfig)
 * @method BasePageTopSidebar addMainSidebar($valueOrConfig)
 * @method BasePageTopSidebar contentHeader($valueOrConfig)
 * @method BasePageTopSidebar addContentHeader($valueOrConfig)
 * @method BasePageTopSidebar notificationArea($valueOrConfig)
 * @method BasePageTopSidebar addNotificationArea($valueOrConfig)
 * @method BasePageTopSidebar data($valueOrConfig)
 * @method BasePageTopSidebar addData($valueOrConfig)
 * @method BasePageTopSidebar footer($valueOrConfig)
 * @method BasePageTopSidebar addFooter($valueOrConfig)
 * @method BasePageTopSidebar title($valueOrConfig)
 * @method BasePageTopSidebar addTitle($valueOrConfig)
 * @method BasePageTopSidebar class($valueOrConfig)
 * @method BasePageTopSidebar addClass($valueOrConfig)
 * @method BasePageTopSidebar iAutoCloseNotification($valueOrConfig)
 * @method BasePageTopSidebar closeNotificationInSeconds($valueOrConfig)
 *
 ********************************************************************************************************************/

class BasePageTopSidebar extends BasePage
{
    /** @var string  */
    protected $view = 'dashboard::pages.base_page_top_sidebar';
}
