<?php


namespace Webmagic\Dashboard\Elements\Forms\Elements;

use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor id($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addId($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor class($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor name($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addName($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor cols($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addCols($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor rows($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addRows($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor title($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addTitle($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor placeholder($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addPlaceholder($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor required(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addRequired(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor content($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor addContent($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor showSpinnerOnBlur(bool $valueOrConfig)
 *
 ********************************************************************************************************************/

class VisualEditor extends Textarea
{
    /** @var  array Sections available in page */
    protected $available_fields = [
        'id',
        'class' => [
            'default' => 'form-control js_summernote'
        ],
        'name',
        'cols' => [
            'default' => '50'
        ],
        'rows' => [
            'default' => '10'
        ],
        'title',
        'placeholder',
        'required' => [
            'type' => 'bool',
            'default' => false,
        ],
        'content',
        'url_on_blur',
        'method_on_blur' => [
            'type' => 'string',
            'default' => 'POST',
        ],
        'show_success_message' => [
            'type' => 'bool',
            'default' => false,
        ],
        'show_error_message' => [
            'type' => 'bool',
            'default' => true,
        ],
        'show_spinner_on_blur' => [
            'type' => 'bool',
            'default' => true,
        ],
    ];

    /**
     * Turn on functionality for upload files
     *
     * Images will be saved as Base64 if this url was not added
     *
     * @param string $uploadUrl
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function turnOnFileUpload(string $uploadUrl): VisualEditor
    {
        $this->attr('data-upload-url', $uploadUrl);

        return $this;
    }

    /**
     *
     * Set URL for sending content of element by AJAX
     *
     * @param string $urlForSendingOnChangeEvent
     * @return $this
     */
    public function urlOnBlur(string $urlForSendingOnChangeEvent): VisualEditor
    {
        $this->url_on_blur = $urlForSendingOnChangeEvent;

        return $this;
    }

    /**
     *
     * Set Method for sending content of element by AJAX
     *
     * @param string $methodForSendingOnChangeEvent
     * @return $this
     */
    public function methodOnBlur(string $methodForSendingOnChangeEvent = 'POST'): VisualEditor
    {
        $this->method_on_blur = $methodForSendingOnChangeEvent;

        return $this;
    }

    /**
     *
     * Is show success message on response
     *
     * @param bool $showSuccessMessageOnChangeEvent
     * @return $this
     */
    public function showSuccessMessage(bool $showSuccessMessageOnChangeEvent = true): VisualEditor
    {
        $this->show_success_message = $showSuccessMessageOnChangeEvent;

        return $this;
    }

    /**
     *
     * Is show error message on response
     *
     * @param bool $showErrorMessageOnChangeEvent
     * @return $this
     */
    public function showErrorMessage(bool $showErrorMessageOnChangeEvent = true): VisualEditor
    {
        $this->show_error_message = $showErrorMessageOnChangeEvent;

        return $this;
    }
}
