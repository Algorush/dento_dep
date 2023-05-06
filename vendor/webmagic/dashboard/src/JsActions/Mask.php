<?php


namespace Webmagic\Dashboard\JsActions;


use Webmagic\Dashboard\Core\Content\JsActionsApplicable;

class Mask extends JsActionApplicator
{
    /** @var string */
    protected $actionClass = 'js_set-mask';

    /**
     * Mask constructor.
     *
     * @param JsActionsApplicable $element
     */
    public function __construct(JsActionsApplicable $element)
    {
        parent::__construct($element);

        $this->addClass();
    }

    /**
     * Add initial class
     */
    protected function addClass()
    {
        $this->element->addClass($this->actionClass);
    }

    /**
     * @param string $dataRegex
     * @param string $dataMask
     * @return JsActionsApplicable
     */
    public function add(string $dataMask = '', string $dataRegex = '')
    {
        $this->element->attrs([
            'data-mask' => $dataMask,
            'data-regex' => $dataRegex,
        ]);

        return $this->element;
    }

    /**
     * @return JsActionsApplicable
     */
    public function number()
    {
        return $this->add('', '[0-9]*');
    }

    /**
     * @return JsActionsApplicable
     */
    public function email()
    {
        return $this->add('_', '^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,})$');
    }

    /**
     * @return JsActionsApplicable
     */
    public function number2DecPlaces()
    {
        return $this->add('_', '([0-9]*)(\.[0-9]{2})');
    }

    /**
     * @return JsActionsApplicable
     */
    public function dateEuro24()
    {
        return $this->add('dd/mm/yyyy hh:mm:ss', '([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4} (([01][0-9])|(2[0-3])):[0-5][0-9]:[0-5][0-9]');
    }

    /**
     * @return JsActionsApplicable
     */
    public function dateUSA12()
    {
        return $this->add('mm/dd/yyyy hh:mm:ss TT', '((0)[0-9])|((1)[0-2])/([0-2][0-9]|(3)[0-1])/[0-9]{4} ((1[0-2]|0?[1-9]):([0-5][0-9]):([0-5][0-9]) ? ([AaPp][Mm]))');
    }

    /**
     * @return JsActionsApplicable
     */
    public function time12h()
    {
        return $this->add('hh:mm:ss TT', '((1[0-2]|0?[1-9]):([0-5][0-9]):([0-5][0-9]) ? ([AaPp][Mm]))');
    }

    /**
     * @return JsActionsApplicable
     */
    public function time24h()
    {
        return $this->add('HH:mm:ss', '^(([01][0-9])|(2[0-3])):[0-5][0-9]:[0-5][0-9]$');
    }

    /**
     * @return JsActionsApplicable
     */
    public function dateUSA()
    {
        return $this->add('mm/dd/yyyy', '^(((0)[0-9])|((1)[0-2]))(\/)([0-2][0-9]|(3)[0-1])(\/)\d{4}$');
    }

    /**
     * @return JsActionsApplicable
     */
    public function dateEuro()
    {
        return $this->add('dd/mm/yyyy', '^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$');
    }

}