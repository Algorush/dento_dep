<?php

namespace Webmagic\Dashboard\NotificationService;


use Illuminate\Support\Facades\Cache;

class NotificationService
{
    /** @var string Cache key for messages */
    protected $messagesKey = 'global-messages-bag';

	/**
	 * @var MessageBag
	 */
	protected $messages;

	/**
	 * @var array
	 */
	protected $types;

	/**
	 * NotificationService constructor.
	 */
	public function __construct()
	{
		$this->messages = $this->prepareMessageBag();

		$this->types = config('webmagic.dashboard.dashboard.available_notification_types');
	}

    /**
     * Load messages bag
     *
     * @return MessageBag
     */
    protected function prepareMessageBag(): MessageBag
    {
        if(!Cache::has($this->messagesKey)){

            $this->messages = new MessageBag();
            $this->saveCurrentMessageBag();
        }

        return Cache::get($this->messagesKey);
    }

    /**
     * Save current message bag
     */
    protected function saveCurrentMessageBag()
    {
        Cache::forever($this->messagesKey, $this->messages);
    }

    /**
     * Add single message
     *
     * @param string $type
     * @param string $message
     * @param string $group
     */
	public function addMessage(string $type = 'info', string $message = '', string $group = 'global')
	{
		$this->messages->add($this->prepareMessagesKey($group, $type), $message);

        $this->saveCurrentMessageBag();
	}

    /**
     * Get all messages grouped by key
     *
     * @param string|null $group
     * @param bool        $saveForLater
     *
     * @return array
     */
	public function getAllMessages(string $group = null, bool $saveForLater = false) : array
	{
        if($group){
            $messages = $this->getGroup($group, '*', $saveForLater);
        } else {
            $messages = $this->messages->getMessages($saveForLater);
        }

        $this->saveCurrentMessageBag();

		return $messages;
	}

    /**
     * Get first message for given key
     *
     * @param string|null $type
     * @param string $group
     * @param bool $saveForLater
     * @return string
     */
	public function getFirstMessage(string $type = '*', string $group = 'global', bool $saveForLater = false) : string
	{
        $messages = $this->messages->first($this->prepareMessagesKey($group, $type), null, $saveForLater);

        $this->saveCurrentMessageBag(); //Save because bag was updated

        return $messages;
	}

    /**
     * Get all messages from given group
     *
     * @param string $group
     * @param string|null $type
     * @param bool $saveForLater
     * @return array
     */
	public function getGroup(string $group, string $type = '*', bool $saveForLater = false) : array
	{
        $messages = $this->messages->get($this->prepareMessagesKey($group, $type), null, $saveForLater);

        $this->saveCurrentMessageBag(); //Save because bag was updated

        return $messages;
	}

    /**
     * Return all messages with specific type
     *
     * @param string $type
     * @param string $group
     * @param bool $saveForLater
     * @return array
     */
    public function getByType(string $type, string $group = 'global', bool $saveForLater = false): array
    {
        $messages = $this->messages->get($this->prepareMessagesKey($group, $type), null, $saveForLater);

        $this->saveCurrentMessageBag();

        return $messages;
    }

    /**
     * Prepare key for getting messages
     *
     * @param string $group
     * @param string $type
     * @return string
     */
    protected function prepareMessagesKey(string $group = 'global', string $type = '*')
    {
        return "$group.$type";
    }

	/**
	 * Is service has any messages
	 *
	 * @return bool
	 */
	public function isNotEmpty() : bool
	{
		return $this->messages->isNotEmpty();
	}

	/**
	 * Check, is message type available by default
	 *
	 * @param string $type
	 * @return bool
	 */
	public function isTypeAvailable(string $type) : bool
	{
		return isset($this->types[$type]);
	}

	/**
	 * Get icon for type
	 *
	 * @param string $type
	 * @return string
	 */
	public function getIconForType(string $type) : string
	{
		if(!isset($this->types[$type]['icon'])){
			return '';
		}

		return $this->types[$type]['icon'];
	}

    /**
     * @param string $type
     *
     * @return bool
     */
    public function isAutoHideActivated(string $type): bool
    {
        if(!isset($this->types[$type]['auto_hide'])){
            return false;
        }

        return $this->types[$type]['auto_hide'];
    }

    /**
     * @param string $type
     *
     * @return int
     */
    public function getAutoHideDelay(string $type): int
    {
        if(!isset($this->types[$type]['auto_hide_delay'])){
            return 5;
        }

        return $this->types[$type]['auto_hide_delay'];
    }
}
