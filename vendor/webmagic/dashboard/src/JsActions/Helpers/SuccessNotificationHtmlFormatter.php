<?php


namespace Webmagic\Dashboard\JsActions\Helpers;


class SuccessNotificationHtmlFormatter
{
    /** @var string */
    protected $title = '';

    /** @var string */
    protected $message = 'Done';

    /** @var string */
    protected $stringForHtml;

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): SuccessNotificationHtmlFormatter
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): SuccessNotificationHtmlFormatter
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        $this->prepare();

        return $this->stringForHtml;
    }

    /**
     * @return void
     */
    protected function prepare()
    {
        $this->stringForHtml = "{'title': '$this->title', 'text': '$this->message'}";
    }
}