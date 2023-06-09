<?php


namespace Webmagic\Dashboard\Elements\Notifications;

use Webmagic\Dashboard\Core\ComplexElement;


/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification title(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification addTitle(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification text(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification addText(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification button(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification addButton(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification type(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification addType(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification icon(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification addIcon(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification autoHide(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Notifications\Notification autoHideDelay($valueOrConfig)
 *
 ********************************************************************************************************************/

class Notification extends ComplexElement
{
	/** @var  string Component view name */
	protected $view = 'dashboard::elements.notifications.dashboard-notification';

	/** @var  array Sections available in page */
	protected $available_fields = [
		'title' => [
			'type' => 'string',
			'default' => 'Info',
		],
		'text' => [
			'type' => 'string',
			'default' => '',
		],
		'button' => [
			'type' => 'bool',
			'default' => true,
		],
		'type' => [
			'type' => 'string',
			'default' => 'info',
			'acceptable_values' => [
				'info',
				'danger',
				'warning',
				'success'
			]
		],
		'icon' => [
			'type' => 'string',
			'default' => 'fas fa-info',
			'acceptable_values' => [
				'fas fa-info',
				'fas fa-ban',
				'fas fa-exclamation-circle',
				'fas fa-check',
				''
			]
		],
        'auto_hide' => [
            'default' => false
        ],
        'auto_hide_delay' => [
            'default' => 5
        ]
	];

	/** @var  string Default section for current component */
	protected $default_field = 'text';

    /**
     * Activate auto hide functionality
     *
     * @param int $delay
     *
     * @return $this
     */
    public function activateAutoHide(int $delay = 5): self
    {
        $this->auto_hide = true;
        $this->auto_hide_delay = $delay;

        return $this;
    }
}
