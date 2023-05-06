<?php


namespace Webmagic\Dashboard\Docs\Http;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\Content\JsActionsApplicable;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;

class JSScriptsPresentationController
{
    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function sortable(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/sortable.md');

        $dashboard->page()
            ->setPageTitle('Sortable JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function controlledCheckboxes(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/controlled-checkboxes.md');

        $dashboard->page()
            ->setPageTitle('Controlled Checkboxes JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Bootstrap dateRangePicker for input functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function dateRangePicker(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/date-range-picker.md');

        $dashboard->page()
            ->setPageTitle('Bootstrap DateRangePicker JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Notifications functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function notifications(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-scripts/notifications.md');

        $dashboard->page()
            ->setPageTitle('Notifications JS script')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($this->prepareNotificationsPopupButtonExample());

        return $dashboard;
    }

    /**
     * @return JsActionsApplicable
     */
    protected function prepareNotificationsPopupButtonExample(): JsActionsApplicable
    {
        return (new DefaultButton('Example custom success response'))
            ->js()->openInModalOnClick()->regular(route('dashboard.docs.presentation.notifications.popup'));
    }

    /**
     * @throws NoOneFieldsWereDefined
     * @throws FieldUnavailable
     */
    public function notificationsCustomResponsePopup(): FormGenerator
    {
        return (new FormGenerator())
            ->action(route('dashboard.docs.presentation.notifications.custom_response'))
            ->ajax()
            ->dontHideModalOnSubmit(true)
            ->input('header', null, 'Header')
            ->input('message', null, 'Message')
            ->submitButton('Submit');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function notificationsCustomResponse(Request $request): JsonResponse
    {
        return response()->json([
            'header' => $request->input('header'),
            'message' => $request->input('message'),
        ]);
    }

    /**
     * Sending Ajax functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function sendAjax(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/send-ajax.md');

        $dashboard->page()
            ->setPageTitle('Sending Ajax JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Input mask functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function inputMask(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/input-mask.md');

        $dashboard->page()
            ->setPageTitle('Input mask JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * File uploader functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function fileUploader(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/file-uploader.md');

        $dashboard->page()
            ->setPageTitle('File uploader JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Added dynamic multifields complex functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function dynamicMultiFieldsComplex(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/dynamic-multifields-complex.md');

        $dashboard->page()
            ->setPageTitle('Dynamically adding multiFields complex JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Added dynamic multifields simple functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function dynamicMultiFieldsSimple(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-scripts/dynamic-multifields-simple.md');

        $dashboard->page()
            ->setPageTitle('Dynamically adding multiFields simple JS script')
            ->addElement()
            ->box()
            ->makeSimple()
            ->content($content);

        return $dashboard;
    }
}
