<?php


namespace Webmagic\Dashboard\JsActions;

use Illuminate\Support\Str;
use Webmagic\Dashboard\Core\Content\JsActionsApplicable;

class HideShowOnClick extends JsActionApplicator
{
    /**
     * @param string $targetBlockClass
     * @param bool $showTargetBlock
     * @return JsActionsApplicable
     */
    public function makeHideShowController(
        string $targetBlockClass,
        bool $showTargetBlock = true
    ): JsActionsApplicable {

        $this->element
            ->addClass('js_toggle-btn')
            ->attr('data-name-blk', Str::start($targetBlockClass, '.'));

        if ($showTargetBlock) {
            $this->element->attr('data-show-blk', '');
        }

        return $this->element;
    }
}
