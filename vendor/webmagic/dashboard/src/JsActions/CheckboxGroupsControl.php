<?php

namespace Webmagic\Dashboard\JsActions;

use Illuminate\Support\Str;
use Webmagic\Dashboard\Core\Content\JsActionsApplicable;

class CheckboxGroupsControl extends JsActionApplicator
{
    /**
     * Configure checkbox to control the group of checkboxes
     *
     * @param string $checkboxGroupID
     * @param bool $unchecked
     * @return JsActionsApplicable
     */
    public function makeCheckboxGroupController(string $checkboxGroupID, bool $unchecked = false): JsActionsApplicable
    {
        $this->prepareElement('js_select-some', $checkboxGroupID, $unchecked);

        return $this->element;
    }

    /**
     * Configure button to control the group of checkboxes
     *
     * @param string|null $checkboxGroupID
     * @param bool $unchecked
     * @param string|null $uncheckedEl
     * @return JsActionsApplicable
     */
    public function makeButtonGroupController(string $checkboxGroupID, bool $unchecked = false, string $uncheckedEl = null): JsActionsApplicable
    {
        $this->prepareElement('js_select-some-btn', $checkboxGroupID, $unchecked);

        if ($uncheckedEl) {
            $this->element->attr('data-unchecked-el', Str::start($uncheckedEl, '.'));
        }

        return $this->element;
    }

    /**
     * Configure checkbox to be controller by remote controller element
     *
     * @param string $checkboxGroupID
     * @param bool $unchecked
     * @return JsActionsApplicable
     */
    public function addCheckboxToControlledGroup(string $checkboxGroupID, bool $unchecked = false): JsActionsApplicable
    {
        $this->element
            ->addClass("js_select-some-$checkboxGroupID")
            ->attr('data-unchecked', $unchecked ? 'true' : 'false');

        return $this->element;
    }

    /**
     * @param string $class
     * @param string $checkboxGroupID
     * @param bool $unchecked
     */
    protected function prepareElement(string $class, string $checkboxGroupID, bool $unchecked = false)
    {
        $this->element
            ->addClass($class)
            ->attr('data-unchecked', $unchecked ? 'true' : 'false')
            ->attr('data-checked-el', ".js_select-some-$checkboxGroupID");
    }
}