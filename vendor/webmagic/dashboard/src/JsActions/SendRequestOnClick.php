<?php


namespace Webmagic\Dashboard\JsActions;

use Illuminate\Support\Str;
use Webmagic\Dashboard\Core\Content\JsActionsApplicable;
use Webmagic\Dashboard\JsActions\Helpers\SuccessNotificationHtmlFormatter;

class SendRequestOnClick extends JsActionApplicator
{
    /** @var string  */
    protected $actionClass = 'js_ajax-by-click-btn';

    /**
     * Apply
     *
     * @param string $action
     * @param array $params
     * @param string $method
     * @param bool $isShowSuccessNotification
     * @param bool $errorNotification
     *
     * @param bool $reloadOnSuccess
     * @param string|null $successNotificationTitle
     * @param string|null $successNotificationText
     * @return JsActionsApplicable
     */
    public function regular(
        string $action,
        array $params = [],
        string $method = 'POST',
        bool $isShowSuccessNotification = true,
        bool $errorNotification = false,
        bool $reloadOnSuccess = false,
        string $successNotificationTitle = null,
        string $successNotificationText = null
    ): JsActionsApplicable {
        $this->applyActionClass();
        $this->applyBasicAttributes($action, $method);
        $this->applyAttrs($params);

        if ($isShowSuccessNotification) {
            $this->applySuccessMessageAttributes(
                $isShowSuccessNotification,
                $successNotificationTitle,
                $successNotificationText
            );
        }

        $this->element->attr('data-error-msg', $errorNotification);
        $this->element->attr('data-reload-after-success', $reloadOnSuccess);

        return $this->element;
    }

    /**
     * @param bool $isShowSuccessNotification
     * @param $successNotificationTitle
     * @param $successNotificationText
     * @return void
     */
    protected function applySuccessMessageAttributes(
        bool $isShowSuccessNotification,
        $successNotificationTitle,
        $successNotificationText
    ) {
        $this->element->attr('data-success-msg', $isShowSuccessNotification);

        $successNotificationHtmlFormatter = new SuccessNotificationHtmlFormatter();

        if (is_string($successNotificationTitle)) {
            $successNotificationHtmlFormatter->setTitle($successNotificationTitle);
        }

        if (is_string($successNotificationText)) {
            $successNotificationHtmlFormatter->setMessage($successNotificationText);
        }

        $this->element->attr('data-success-msg-txt', $successNotificationHtmlFormatter->get());
    }

    /**
     *  Put the response content to the block
     *
     * @param string $action
     * @param string $resultIdentifier
     * @param array $params
     * @param string $method
     * @param bool $isShowSuccessNotification
     * @param bool $errorNotification
     *
     * @param bool $reloadOnSuccess
     * @param string|null $successNotificationTitle
     * @param string|null $successNotificationText
     * @return JsActionsApplicable
     */
    public function showResponse(
        string $action,
        string $resultIdentifier,
        array $params = [],
        string $method = 'POST',
        bool $isShowSuccessNotification = true,
        bool $errorNotification = false,
        bool $reloadOnSuccess = false,
        string $successNotificationTitle = null,
        string $successNotificationText = null
    ): JsActionsApplicable {
        $this->element->attr('data-result-blk', Str::start($resultIdentifier, '.'));

        return $this->regular(
            $action,
            $params,
            $method,
            $isShowSuccessNotification,
            $errorNotification,
            $reloadOnSuccess,
            $successNotificationTitle,
            $successNotificationText
        );
    }

    /**
     *  Replace the block with the response content
     *
     * @param string $action
     * @param string $replacingIdentifier
     * @param array $params
     * @param string $method
     *
     * @param bool $successNotification
     * @param bool $errorNotification
     *
     * @param bool $reloadOnSuccess
     * @param string|null $successNotificationTitle
     * @param string|null $successNotificationText
     * @return JsActionsApplicable
     */
    public function replaceWithResponse(
        string $action,
        string $replacingIdentifier,
        array $params = [],
        string $method = 'POST',
        bool $successNotification = true,
        bool $errorNotification = false,
        bool $reloadOnSuccess = false,
        string $successNotificationTitle = null,
        string $successNotificationText = null
    ): JsActionsApplicable {
        $this->element->attr('data-replace-blk', Str::start($replacingIdentifier, '.'));

        return $this->regular(
            $action,
            $params,
            $method,
            $successNotification,
            $errorNotification,
            $reloadOnSuccess,
            $successNotificationTitle,
            $successNotificationText
        );
    }

    /**
     * Apply basic attributes
     *
     * @param string              $action
     * @param string              $method
     *
     */
    protected function applyBasicAttributes(string $action, string $method)
    {
        $this->element->attrs([
            'data-action' => $action,
            'data-method' => $method
        ]);
    }

    /**
     * Apply action class
     *
     */
    protected function applyActionClass()
    {
        $this->element->addClass($this->actionClass);
    }

    /**
     * Apply params
     *
     * @param array $params
     */
    protected function applyAttrs(array $params)
    {
        $params = $this->formatParams($params);

        $this->element->attrs($params);
    }

    /**
     * add prefix for request parameters 'data-'.
     * don't use function dataAttrs for compatibility with existing code
     *
     * @param array $params
     * @return array
     */
    protected function formatParams(array $params): array
    {
        foreach ($params as $name => $value) {
            if (Str::startsWith($name, 'data-')) {
                continue;
            }
            $formattedName = Str::start($name, 'data-');
            $params[$formattedName] = $value;
            unset($params[$name]);
        }

        return $params;
    }
}
