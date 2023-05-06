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
 * @method BasePage headerLogo($valueOrConfig)
 * @method BasePage addHeaderLogo($valueOrConfig)
 * @method BasePage headerNav($valueOrConfig)
 * @method BasePage addHeaderNav($valueOrConfig)
 * @method BasePage mainSidebar($valueOrConfig)
 * @method BasePage addMainSidebar($valueOrConfig)
 * @method BasePage contentHeader($valueOrConfig)
 * @method BasePage addContentHeader($valueOrConfig)
 * @method BasePage notificationArea($valueOrConfig)
 * @method BasePage addNotificationArea($valueOrConfig)
 * @method BasePage data($valueOrConfig)
 * @method BasePage addData($valueOrConfig)
 * @method BasePage footer($valueOrConfig)
 * @method BasePage addFooter($valueOrConfig)
 * @method BasePage title($valueOrConfig)
 * @method BasePage addTitle($valueOrConfig)
 * @method BasePage class($valueOrConfig)
 * @method BasePage addClass($valueOrConfig)
 * @method BasePage iAutoCloseNotification($valueOrConfig)
 * @method BasePage closeNotificationInSeconds($valueOrConfig)
 *
 ********************************************************************************************************************/

class BasePage extends Page
{
    /** @var string  */
    protected $view = 'dashboard::pages.base_page';

    protected $available_fields = [
        'header_logo',
        'header_nav',
        'main_sidebar',
        'content_header',
        'breadcrumbs',
	    'notification_area',
	    'data',
        'footer',
        'title',
        'class',
        'header_nav_style',
        'side_bar_class',
        'footer_class',
        'aside_class',
        'is_auto_close_notification',
        'close_notification_in_seconds' => [
            'default' => 4,
        ]
    ];

    protected $default_field = 'data';

	protected $isGlobalNotificationsAllowed = true;

    /**
     * Make sidebar collapsed
     */
    public function makeSidebarCollapsed()
    {
        $this->addClass('sidebar-collapse');
	}


	/**
     * Set page meta title and title
     *
     * @param string $title
     * @param string $subTitle
     *
     * @return BasePage
     */
    public function setPageTitle(string $title, string $subTitle = ''): BasePage
    {
        $this->title($title);
        $this->element('content_header')->h1Title($title)->subTitle($subTitle);

        return $this;
    }

    /**
     * Add notifications to page before render()
     *
     * @return BasePage
     * @throws BindingResolutionException
     */
	private function addGlobalNotifications(): BasePage
	{
		/** @var NotificationService $notificationService */
		$notificationService = app()->make(NotificationService::class);
        $notificationsGroup = 'global';
		if ($notificationService->isNotEmpty()) {
			foreach ($notificationService->getAllMessages($notificationsGroup) as $key => $messages) {
				// set default type & icon style
                $notification = (new Notification())->type( 'info')->icon('fa-info');

                $messageType = str_replace("$notificationsGroup.", '', $key);
				foreach ($messages as $message) {
					if ($notificationService->isTypeAvailable($messageType)) {
                        $notification
                            ->title(ucfirst($messageType))
                            ->type($messageType)
                            ->icon($notificationService->getIconForType($messageType));
					}

                    if($notificationService->isAutohideActivated($messageType)){
                        $notification->activateAutoHide($notificationService->getAutoHideDelay($messageType));
                    }

                    $notification->text($message);
					$this->addContent($notification, 'notification_area');
				}
			}
		}

		return $this;
	}

	/**
	 * Disable global notifications before render()
	 */
	public function turnOffGlobalNotifications()
	{
		$this->isGlobalNotificationsAllowed = false;
	}

    /**
     * Set custom notification to page
     *
     * @param string $title
     * @param string $text
     * @param bool $closeButton
     * @param string $type
     * @param string $icon
     * @param bool $autoHide
     * @param int|null $autoHideDelay
     * @return BasePage
     * @throws NoOneFieldsWereDefined
     */
	public function showNotification(
		string $title,
		string $text = '',
		bool $closeButton = true,
		string $type = 'info',
		string $icon = 'fas fa-info',
        bool $autoHide = false,
        ?int $autoHideDelay = null
	): BasePage {
		$notification = $this->addElement('notification_area')
			->notification()->title($title)->text($text)->button($closeButton)->type($type)->icon($icon)->autoHide($autoHide);

        if ($autoHideDelay) {
            $notification->autoHideDelay($autoHideDelay);
        }

		return $this;
	}

    /**
     * Show Info notification
     *
     * @param string $title
     * @param string $text
     * @param bool $closeButton
     * @param bool $autoHide
     * @param int|null $autoHideDelay
     * @return BasePage
     * @throws NoOneFieldsWereDefined
     */
	public function showInfoNotification(string $title, string $text = '', bool $closeButton = true, bool $autoHide = false, int $autoHideDelay = null): BasePage
	{
		return $this->showNotification($title, $text, $closeButton, 'info', 'fas fa-info', $autoHide, $autoHideDelay);
	}

    /**
     * Show Danger notification
     *
     * @param string $title
     * @param string $text
     * @param bool $closeButton
     * @param bool $autoHide
     * @param int|null $autoHideDelay
     * @return BasePage
     * @throws NoOneFieldsWereDefined
     */
	public function showDangerNotification(string $title, string $text = '', bool $closeButton = true, bool $autoHide = false, int $autoHideDelay = null): BasePage
	{
		return $this->showNotification($title, $text, $closeButton, 'danger', 'fas fa-ban', $autoHide, $autoHideDelay);
	}

    /**
     * Show Warning notification
     *
     * @param string $title
     * @param string $text
     * @param bool $closeButton
     * @param bool $autoHide
     * @param int|null $autoHideDelay
     * @return BasePage
     * @throws NoOneFieldsWereDefined
     */
	public function showWarningNotification(string $title, string $text = '', bool $closeButton = true, bool $autoHide = false, int $autoHideDelay = null): BasePage
	{
		return $this->showNotification($title, $text, $closeButton, 'warning', 'fas fa-exclamation-circle', $autoHide, $autoHideDelay);
	}

    /**
     * Show Warning notification
     *
     * @param string $title
     * @param string $text
     * @param bool $closeButton
     * @param bool $autoHide
     * @param int|null $autoHideDelay
     * @return BasePage
     * @throws NoOneFieldsWereDefined
     */
	public function showSuccessNotification(string $title, string $text = '', bool $closeButton = true, bool $autoHide = false, int $autoHideDelay = null): BasePage
	{
		return $this->showNotification($title, $text, $closeButton, 'success', 'fas fa-check', $autoHide, $autoHideDelay);
	}

    /**
     * @inheritDoc
     * @return string
     * @throws BindingResolutionException
     */
	public function render(): string
	{
		if($this->isGlobalNotificationsAllowed) {
			$this->addGlobalNotifications();
		}

		return parent::render(); // TODO: Change the autogenerated stub
	}
}
