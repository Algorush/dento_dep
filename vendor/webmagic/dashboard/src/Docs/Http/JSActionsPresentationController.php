<?php


namespace Webmagic\Dashboard\Docs\Http;


use Illuminate\Http\Request;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Boxes\Box;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Forms\Elements\Checkbox;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Forms\Elements\Select;
use Webmagic\Dashboard\Elements\Links\LinkButton;
use Webmagic\Dashboard\Elements\Forms\Elements\Input;
use Webmagic\Dashboard\Elements\Titles\H4Title;
use Webmagic\Dashboard\Elements\WrapperDiv;
use Webmagic\Dashboard\Elements\WrapperSpan;
use function request;

class JSActionsPresentationController
{
    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function controlledCheckboxes(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-actions/control-checkboxes.md');

        $checkboxGroupIdentifier = 'some_group';
        $checkboxGroupCanBeUnselect = 'checkbox_group_can_be_unselect';
        $unchecked = false;

        $dashboard->page()
            ->setPageTitle('Controlled checkboxes')
            ->addElement()->box()->makeSimple()->content($content)
            ->parent('page')->addElement()->box()->makeSimple()->content(
                (new H4Title('Example')),
                (new FormGroup(
                    (new \Webmagic\Dashboard\Elements\Buttons\DefaultButton())
                        ->class('btn-default')
                        ->js()->checkboxGroupsControl()
                        ->makeButtonGroupController($checkboxGroupIdentifier, $unchecked, $checkboxGroupCanBeUnselect)
                        ->content('Checkbox group controller')
                        ->icon('fa-check')
                )),
                (new FormGroup(
                    (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())
                        ->js()->checkboxGroupsControl()->makeCheckboxGroupController($checkboxGroupIdentifier, $unchecked)
                        ->content('Checkbox group controller')
                )),
                (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())
                    ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup($checkboxGroupIdentifier, $unchecked)
                    ->content('Checkbox One'),
                '<br>',
                (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())
                    ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup($checkboxGroupIdentifier, $unchecked)
                    ->content('Checkbox Two'),
                '<br>',
                (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox('Button can unselect this checkbox'))
                    ->addClass($checkboxGroupCanBeUnselect)
                    ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup('other_control_group_class', $unchecked),
                '<br>',
                (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox('Button CAN\'t unselect this checkbox'))
                    ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup('other_control_group_class', $unchecked),
                '<br>',
            )
        ;

        return $dashboard;
    }

    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function tooltips(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-actions/tooltips.md');

        $addTooltip = (new FormGroup())->labelTxt('Checkbox with tooltip')->element()->checkbox()->js()->tooltip()->regular('This is an input with tooltip')->parent();
        $hideAddedTooltip = (new FormGroup())->labelTxt('Checkbox with hidden tooltip')->element()->checkbox()->js()->tooltip()->regular('Hidden tooltip')->js()->tooltip()->hide()->parent();


        $dashboard->page()
            ->setPageTitle('Tooltips functionality')
            ->addElement()->tabs()->addTab()->title('Description')->content($content)->active()
            ->parent()->addTab()->title('Example')->content([$addTooltip, $hideAddedTooltip]);

        return $dashboard;
    }

    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function confirmationPopup(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/confirmation-popup.md');

        $btn = (new LinkButton())->content('Action element')
            ->js()->sendRequestOnClick()->regular(url()->current())
            ->js()->confirmationPopup()->regular(
                'Confirm this action',                          // title
                'Please, make sure you want to do this',     // content
                'I confirm',                               // confirm button
                'Do not do this'                            // cancel button
            );

        $dashboard->page()
            ->setPageTitle('Confirm popup functionality')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($btn);

        return $dashboard;
    }

    /**
     * @return string
     */
    public function confirmationPopupDeleting(): string
    {
        return 'deleted';
    }

    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function contentCopyToClipboard(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-actions/content-copy-to-clipboard.md');

        $btn1 = (new DefaultButton())
            ->addClass('btnClass')
            ->attr('id', 'testId')
            ->js()
            ->contentCopy()
            ->getElementValueToClipboard('.btnClass')
            ->content('Copy this button value');

        $inputText = (new Input())
            ->id('id_of_other_element')
            ->addClass('class_of_other_element')
            ->value('Value');

        $btn2 = (new DefaultButton())->js()
            ->contentCopy()
            ->getElementValueToClipboard('#id_of_other_element')
            ->content('Copy value from other element');

        $btn3 = (new DefaultButton())->js()
            ->contentCopy()
            ->getCurrentElementAttrToClipboard('attribute value')
            ->content('Copy this button attribute value');

        $dashboard->page()
            ->addElement()->tabs()->addTab()->title('Description')->content($content)->active()
            ->parent()->addTab()->title('Example')->content([$btn1, '<br><br>', $inputText, '<br>', $btn2, '<br><br>', $btn3]);

        return $dashboard;
    }

    /**
     * Hide/show functionality presentation
     *
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function hideShowOnClick(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-actions/hide-show-on-click.md');

        $formGenerator = (new FormGenerator())
            ->input('some_input', 'some value')
            ->dateTimeRangePicker('start', 'end', null, null, 'DateTimeRangePicker')
            ->textarea('text_area', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.')
            ->submitButton('Submit');

        $box = new Box();
        $box->headerAvailable(false);
        $box->addClass('box_class mt-4');
        $box->addContent($formGenerator);

        $btnController = (new DefaultButton())->content('Hide/show form')
            ->js()->hideShowOnClick()->makeHideShowController('box_class', true);

        $wrapper = new WrapperDiv();
        $wrapper->addContent($btnController);
        $wrapper->addContent($box);

        $dashboard->page()
            ->setPageTitle('Hide show on click')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($content)->active()
            ->parent()->addElement()->tab()->title('Example')->content($wrapper);

        return $dashboard;
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function activityController(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/activity-controller.md');

        $example = $this->prepareActivityControllerExample();

        $dashboard->page()
            ->setPageTitle('Activity controller')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);
        return $dashboard;
    }

    /**
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareActivityControllerExample(): WrapperDiv
    {
        $checkboxForInputId = uniqid();

        $inputText = new Input('input text');
        $inputText->js()->activityController()->addDisabilityController(".$checkboxForInputId", false);

        $checkboxForInput = new Checkbox();
        $checkboxForInput->content('Check to make input inactive');
        $checkboxForInput->checked(false);
        $checkboxForInput->addClass($checkboxForInputId);

        $formBlockClass = uniqid();
        $checkboxForForm = new Checkbox();
        $checkboxForForm->content('Uncheck to show form');
        $checkboxForForm->checked(true);
        $checkboxForForm->addClass($formBlockClass);

        $formBlock = $this->getFormForActivityController();
        $formBlock->js()->activityController()->addVisibilityController(".$formBlockClass", false);

        $wrapper = new WrapperDiv();
        $wrapper->addContent(
            (new WrapperDiv([
                new H4Title('Disable element'),
                $checkboxForInput,
                $inputText
            ]))->addClass('mb-5')
        );

        $wrapper->addContent('<hr>');

        $wrapper->addContent(
            (new WrapperDiv([
                new H4Title('Show element'),
                $checkboxForForm,
                $formBlock
            ]))->addClass('mt-5')
        );

        return $wrapper;
    }

    /**
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function getFormForActivityController(): WrapperDiv
    {
        return
            new WrapperDiv(
                (new FormGenerator())
                    ->action(request()->url())
                    ->method('GET')
                    ->textInput('name', '', 'User name:')
                    ->passwordInput('name', '', 'User password:')
                    ->submitButton('Submit form')
            );
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function openInModal(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/open-in-modal.md');

        $exampleOpenInModalOnClick = $this->prepareExampleOpenInModal();

        $dashboard->page()
            ->setPageTitle('Open in modal')
            ->addElement()->tabs()->addTab()->title('Description')->content($docs)->active()
            ->parent()->addTab()->title('Example')->content($exampleOpenInModalOnClick);

        return $dashboard;
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareExampleOpenInModal(): WrapperDiv
    {
        $button = new DefaultButton('Click me!');
        $button->addClass('mb-4');
        $button->js()->openInModalOnClick()->bigModal(
            route('dashboard.docs.presentation.js-actions.open-in-modal-on-click'),
            'POST',
            'Title',
            true
        );

        $select = new Select();
        $select->options(['one', 'two', 'three']);
        $select->addClass('mb-4');
        $select->js()->openInModalOnChange()->smallModal(route('dashboard.docs.presentation.js-actions.open-in-modal-on-change'));

        return new WrapperDiv([
            new H4Title('Open in modal on click'),
            $button,
            new H4Title('Open in modal on change'),
            $select
        ]);
    }

    /**
     * @return string
     */
    public function openInModalOnClick(): string
    {
        return 'openInModalOnClick';
    }

    /**
     * @return string
     */
    public function openInModalOnChange(): string
    {
        return 'openInModalOnChange';
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function sendRequest(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/send-request.md');

        $example = $this->prepareExampleForSendRequest();

        $dashboard->page()
            ->setPageTitle('Send request')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);
        return $dashboard;
    }

    /**
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareExampleForSendRequest(): WrapperDiv
    {
        $route = route('dashboard.docs.presentation.js-actions.process-send-request');
        $buttonSimpleSendRequest = new DefaultButton('Click');
        $buttonSimpleSendRequest->js()->sendRequestOnClick()->regular($route, [], 'POST', true, true, true);

        $buttonSendRequestWithoutReload = new DefaultButton('Click');
        $buttonSendRequestWithoutReload->js()->sendRequestOnClick()->regular($route, [], 'POST', true, true, false, 'title', 'text');

        $buttonSendRequestWithoutSuccess = new DefaultButton('Click');
        $buttonSendRequestWithoutSuccess->js()->sendRequestOnClick()->regular($route, [], 'POST', false, true, false);

        $routeWithError = route('dashboard.docs.presentation.js-actions.send-request-with-error');
        $buttonSendRequestWithErrorNotification = new DefaultButton('Click');
        $buttonSendRequestWithErrorNotification->js()->sendRequestOnClick()->regular($routeWithError, [], 'POST', false, true, false);

        $routeWithResultBlock = route('dashboard.docs.presentation.js-actions.send-request-to-result-block');
        $buttonShowResponseInBlock = new DefaultButton('Click');
        $buttonShowResponseInBlock->js()->sendRequestOnClick()->showResponse($routeWithResultBlock, '.result-block', ['data-some' => 'Value for result block.']);

        $routeForReplaceBlock = route('dashboard.docs.presentation.js-actions.send-request-to-replace-block');
        $buttonShowResponseByReplaceBlock = new DefaultButton('Click');
        $buttonShowResponseByReplaceBlock->js()->sendRequestOnClick()->replaceWithResponse($routeForReplaceBlock, '.replace-block', ['some' => 'Value for replace block.']);

        return new WrapperDiv([
            new H4Title('Send request with reload page'),
            $buttonSimpleSendRequest,
            new H4Title('Send request without reload page'),
            $buttonSendRequestWithoutReload,
            new H4Title('Send request without success notification and without reload page'),
            $buttonSendRequestWithoutSuccess,
            new H4Title('Send request with error notification'),
            $buttonSendRequestWithErrorNotification,
            new H4Title('Send request and pass response to block'),
            (new WrapperDiv('(Result block)'))->addClass('result-block'),
            $buttonShowResponseInBlock,
            new H4Title('Send request and replace result by response'),
            (new WrapperDiv('(Replace block)'))->addClass('replace-block'),
            $buttonShowResponseByReplaceBlock
        ]);
    }

    /**
     * @return void
     */
    public function requestWithError()
    {
        abort(500, 'Error message');
    }

    /**
     * @return string
     */
    public function processSendRequest()
    {
        return 'process';
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws NoOneFieldsWereDefined
     */
    public function sendRequestToResultBlock(Request $request)
    {
        return (new WrapperDiv($request->some . ' From server ' . uniqid()))->addClass('result-block');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws NoOneFieldsWereDefined
     */
    public function sendRequestToReplaceBlock(Request $request)
    {
        return (new WrapperDiv($request->some . ' From server ' . uniqid()))->addClass('replace-block');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function deleteWithConfirmation(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/delete-with-confirmation.md');

        $example = $this->prepareDeleteWithConfirmationExample();

        $dashboard->page()
            ->setPageTitle('Delete with confirmation')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);
        return $dashboard;
    }

    /**
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareDeleteWithConfirmationExample(): WrapperDiv
    {
        $route = route('dashboard.docs.presentation.js-actions.delete-with-confirmation-deleting');

        $blackButtonClass = uniqid();
        $blackButton = new DefaultButton();
        $blackButton->class('btn btn-dark m-3 ' . $blackButtonClass);
        $blackButton->content('Remove Myself');
        $blackButton->attr('style', 'width: 232px');
        $blackButton->js()->deleteWithConfirmation()->regular($route,".$blackButtonClass");

        $blueButtonClass = uniqid();
        $blueButton = new DefaultButton('Blue');
        $blueButton->class('btn btn-primary m-3 ' . $blueButtonClass);
        $blueButton->attr('style', 'width: 100px');

        $grayButtonClass = uniqid();
        $grayButton = new DefaultButton('Gray');
        $grayButton->class('btn btn-secondary m-3 ' . $grayButtonClass);
        $grayButton->attr('style', 'width: 100px');

        $redButtonClass = uniqid();
        $redButton = new DefaultButton();
        $redButton->class('btn btn-danger m-3 ' . $redButtonClass);
        $redButton->content('Remove Blue and Gray');
        $redButton->attr('style', 'width: 232px');
        $redButton->js()->deleteWithConfirmation()->regular($route,".$blueButtonClass, .$grayButtonClass");

        $greenButton = new DefaultButton();
        $greenButton->class('btn btn-success m-3');
        $greenButton->content('Remove Red');
        $greenButton->attr('style', 'width: 232px');
        $greenButton->js()->deleteWithConfirmation()->regular($route,".$redButtonClass");

        return new WrapperDiv([
            (new WrapperDiv($blueButton))->addClass('float-left'),
            (new WrapperDiv($grayButton))->addClass('float-left'),
            (new WrapperDiv(''))->addClass('clearfix'),
            (new WrapperDiv($redButton)),
            (new WrapperDiv($greenButton)),
            (new WrapperDiv($blackButton)),
        ]);
    }

    /**
     * @return string
     */
    public function deleteWithConfirmationDeleting(): string
    {
        return 'deleted';
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function editableText(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/editable-text.md');

        $example = $this->prepareEditableTextExample();

        $dashboard->page()
            ->setPageTitle('Editable text')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);
        return $dashboard;
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareEditableTextExample()
    {
        $div = new WrapperDiv('content');

        return $div->js()->editableText()->regular(
            'name', route('dashboard.docs.presentation.js-actions.send-editable-text'), 'post', true
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editableTextProcess(Request $request)
    {
        return $request->input('name');
    }
}
