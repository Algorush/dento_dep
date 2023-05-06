<?php

namespace Webmagic\Dashboard\NotificationService;

use Illuminate\Support\Str;

class MessageBag extends \Illuminate\Support\MessageBag
{
    /**
     * @param null $key
     * @param null $format
     * @param bool $saveForLater
     * @return string
     */
    public function first($key = null, $format = null, bool $saveForLater = true)
    {
        $messages =  parent::first($key, $format);

        if(!$saveForLater){
            $this->remove($key, true);
        }

        return $messages;
    }

    /**
     * @param string $key
     * @param null $format
     * @param bool $saveForLater
     * @return array
     */
    public function get($key, $format = null,  bool $saveForLater = true)
    {
        $messages =  parent::get($key, $format);

        if(!$saveForLater){
            $this->remove($key);
        }

        return $messages;
    }

    /**
     * Get the raw messages in the message bag.
     *
     * @return array
     */
    public function getMessages(bool $saveForLater = false)
    {
        $messages = parent::messages();

        if(!$saveForLater){
            $this->messages = [];
        }

        return $messages;
    }


    /**
     * @param string $key
     * @param bool $firstMessageOnly
     */
    public function remove(string $key, bool $firstMessageOnly = false)
    {
        // Clear for wildcard
        if(Str::contains($key, '*')){
            foreach ($this->messages as $messagesKey => $val){
                if(Str::is($key, $messagesKey)){
                    unset($this->messages[$messagesKey]);
                }
            }

            return;
        }

        if(empty($this->messages[$key])){
            return;
        }

        // Remove one message
        if($firstMessageOnly && count($this->messages[$key]) > 1){
            array_shift($this->messages[$key]);

            return;
        }

        // Remove whole group
        unset($this->messages[$key]);
    }
}