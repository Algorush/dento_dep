<?php

namespace Webmagic\Dashboard\JsActions;

use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\WrapperDiv;

class EditableText extends JsActionApplicator
{
    /**
     * @param $name
     * @param $url
     * @param string $method
     * @param bool $showEditableMark
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    public function regular($name, $url, string $method = 'POST', bool $showEditableMark = true): WrapperDiv
    {
        $this->element->addClass('editable-txt js_editable-cnt');

        $this->element->attrs([
            'contenteditable' => 'true',
            'data-url' => $url,
            'data-field-name' => $name,
            'data-default-content' => $this->element->content ?? '',
            'data-method' => $method
        ]);

        if ($showEditableMark) {
            $this->element->attr('data-edit-icon', '');
        }

        $element = new WrapperDiv($this->element);
        $element->addClass('editable-wrap js_editable-wrap');

        return $element;
    }
}
