<?php


namespace Webmagic\Dashboard\Docs\Http;

use Faker\Generator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Throwable;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Components\TableGenerator;
use Webmagic\Dashboard\Components\TablePageGenerator;
use Webmagic\Dashboard\Components\TilesListPageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Docs\Traits\CapitalsTrait;
use Webmagic\Dashboard\Elements\Badge;
use Webmagic\Dashboard\Elements\Files\PhotoUploader;
use Webmagic\Dashboard\Elements\Forms\Elements\Checkbox;
use Webmagic\Dashboard\Elements\Forms\Elements\Color;
use Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Forms\Elements\Select;
use Webmagic\Dashboard\Elements\Forms\Elements\SelectJS;
use Webmagic\Dashboard\Elements\Forms\Elements\Switcher;
use Webmagic\Dashboard\Elements\Forms\Elements\Textarea;
use Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor;
use Webmagic\Dashboard\Elements\Grid\Grid;
use Webmagic\Dashboard\Elements\Icons\Icon;
use Webmagic\Dashboard\Elements\Lists\DataList;
use Webmagic\Dashboard\Elements\Lists\DescriptionList;
use Webmagic\Dashboard\Elements\Image;
use Webmagic\Dashboard\Elements\Menus\MainMenu\Item;
use Webmagic\Dashboard\Elements\Menus\MainMenu\MainMenu;
use Webmagic\Dashboard\Elements\Notifications\Notification;
use Webmagic\Dashboard\Elements\ProgressBar\ProgressBar;
use Webmagic\Dashboard\Elements\StringElement;
use Webmagic\Dashboard\Elements\Links\LinkButton;
use Webmagic\Dashboard\Elements\Links\LinkJSDelete;
use Webmagic\Dashboard\Elements\Tables\TableCell;
use Webmagic\Dashboard\Elements\Tables\TableTitle;
use Webmagic\Dashboard\Elements\Titles\H4Title;
use Webmagic\Dashboard\Elements\Tabs\Tabs;
use Webmagic\Dashboard\Elements\Widgets\BoxWidget;
use Webmagic\Dashboard\Elements\Widgets\ProgressWidget;
use Webmagic\Dashboard\Elements\Widgets\SimpleWidget;
use Webmagic\Dashboard\Elements\WrapperDiv;
use Webmagic\Dashboard\Elements\WrapperSpan;
use Webmagic\Dashboard\Elements\Graphics\Graphic;
use Webmagic\Dashboard\JsActions\Mask;
use Webmagic\Dashboard\Elements\Boxes\Box;
use Webmagic\Dashboard\Elements\Breadcrumbs\Breadcrumbs;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Factories\ElementsFactory;
use Webmagic\Dashboard\Elements\Forms\Elements\Input;
use Webmagic\Dashboard\Elements\Links\Link;
use Webmagic\Dashboard\Pages\BlankPage;
use Webmagic\Dashboard\Pages\LoginPage;
use Webmagic\Dashboard\Services\FakeDataService;

class PresentationController
{
    use CapitalsTrait;

    /**
     * Table page generation description
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function installation(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/installation.md');

        $dashboard->page()
            ->addElement()
            ->box()->makeSimple()
            ->content($content);

        return $dashboard;
    }

    /**
     * Table page generation description
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function tablePageDescription(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/pages/table-page.md');

        $dashboard->page()
            ->addElement()
            ->box()
            ->addToolsLinkButton(
                route('dashboard.docs.presentation.table-page'),
                'Example',
                '',
                'btn-info'
            )
            ->content($content);

        return $dashboard;
    }

    /**
     * Prepare Table Page for presentation
     *
     * @return mixed
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function tablePage()
    {
        /** @var Generator $faker */
        $faker = app(Generator::class);
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id'      => $faker->numberBetween(0, 100),
                'name'    => $faker->name,
                'address' => $faker->address,
            ];
        }

        $paginator = new LengthAwarePaginator($data, 100, 10, 5);

        $tableGenerator = (new TablePageGenerator())
            ->title('Page title', 'Page subtitle')
            // Add items
            ->items($data)
            // Set titles
            ->tableTitles('ID', 'Address')
            // Alternative setting titles
            ->tableTitles(['ID', 'Address'])
            // Add additional title
            ->addTableTitle('Address && Name')
            ->addTableTitle((new TableTitle('Table title'))->attr('some-attr', 'some-value'))
            ->addTableTitle('New field static')
            // Add title with sorting
            ->addTitleWithSorting('New field', 'sortingFieldName', 'desc', true, request()->url(), 'GET')
            ->addTableTitle('Control buttons')
            // Limit fields to show
            ->showOnly('id', 'address', 'address-name', 'new-field', 'new-field2', 'second-new-field')
            // Add additional fields and items  fields handlers
            ->setConfig([
                'address'      => function ($item) {
                    return (new Link())->content($item['address'])->link('/');
                },
                'address-name' => function ($item) {
                    return '<b>' . $item['name'] . '</b> (' . $item['address'] . ')';
                },
                'new-field'    => 'New field static content',
                'new-field2'    => (new TableCell('New field static content2'))->attr('custom-attr', 'custom-value'),
            ])
            // Add one additional field to content
            ->addToConfig('second-new-field', function ($item) {
                return 'New field static - ' . $item['id'];
            })
            // Add crude links
            ->createLink(url('/'))
            ->setEditLinkClosure(function ($item) {
                return url('/edit', ['id' => $item['id']]);
            })
            ->setShowLinkClosure(function ($item) {
                return url('/view', ['id' => $item['id']]);
            })
            ->setDestroyLinkClosure(function ($item) {
                return url('/destroy', ['id' => $item['id']]);
            })
            // Add custom element to tool column
            ->addElementsToToolsCollection(function ($item) {
                return (new DefaultButton())
                    ->content($item['name'])->js()->tooltip()->regular('Test button description');
            })
            // Add pagination
            ->withPagination($paginator, request()->url())
            // Add additional tool button
            ->addToolsLinkButton('/', 'New tool button', 'fas fa-plus')
            // Activate bulk actions functionality
            ->bulkActions([
                url()->current() => 'Action 1',
                url('/')         => 'Action 2',
            ], function ($item) {
                return $item['id'];
            })
            // Manual sorting activation
            ->manualSorting(url()->current(), function ($item) {
                return $item['id'];
            }, 'GET');

        $tableGenerator->getPage()->showDangerNotification('Danger!', 'Lorem ipsum...');

        // Add filtering
        $tableGenerator->addFiltering()
            ->action(request()->url())
            ->method('GET')
            ->simpleSelect('name', ['Dan', 'Vincent'], request(), 'Name', true)
            ->dateTimeInput('date', today(), 'Datetime', false)
            ->submitButton('Filter')
            ->clearButton('Clear');

        return $tableGenerator;
    }

    /**
     * Login page generation description
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function loginPageDescription(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/pages/login-page.md');

        $dashboard->page()
            ->addElement()
            ->box()
            ->makeSimple()
            ->addToolsLinkButton(
                route('dashboard.docs.presentation.login-page-demo'),
                'Example',
                '',
                'btn-info'
            )
            ->content($content);

        return $dashboard;
    }

    /**
     * Login page generation demo
     *
     * @param LoginPage $page
     *
     * @return LoginPage
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function loginPageDemo(LoginPage $page): LoginPage
    {
        $page->setDefaultForm();

        return $page;
    }

    /**
     * Show tiles list page description
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function tilesListPageDescription(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/pages/tiles-list-page.md');

        $dashboard->page()
            ->addElement()
            ->box()
            ->addToolsLinkButton(
                route('dashboard.docs.presentation.tiles-list-page'),
                'Example',
                '',
                'btn-info'
            )
            ->content($content);

        return $dashboard;
    }

    /**
     * Show tiles list page demosntration
     *
     * @return string|TilesListPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function tilesListPage()
    {
        /** @var Generator $faker */
        $faker = app(Generator::class);
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id'      => $faker->numberBetween(0, 100),
                'name'    => $faker->name,
                'address' => $faker->address,
            ];
        }

        $paginator = new LengthAwarePaginator($data, 100, 10, 5);

        $tilesListPage = (new TilesListPageGenerator())
            ->title('Tiles page title', 'Tiles page subtitle')
            // Add items
            ->setItems($data)
            // Limit fields to show
            ->setOnly('name', 'tmp', 'second-new-field')
            ->setConfig([
                'tmp' => function (array $item) {
                    return $item['name'] . ' : ' . $item['address'];
                },
            ])
            // Add one additional field to content
            ->addToConfig('second-new-field', function ($item) {
                return 'New field startic - ' . $item['id'];
            })
            // Set closure to replace the default rendering
            ->setItemRenderingClosure(function ($item) {
                return app(ElementsFactory::class)
                    ->box()->content($item['name'])->makeSimple();
            })
            // Add pagination
            ->withPagination($paginator, url()->current());

        $tilesListPage->getPage()->showInfoNotification('Info!', 'Lorem ipsum...');

        // Add filtering
        $tilesListPage
            // Filter into the box
            ->addFiltering(true)
            ->simpleSelect('name', ['Dan', 'Vincent'], request(), 'Name', true)
            ->dateTimeInput('date', today(), 'Datetime', false)
            ->submitButton('Filter');

        if (request()->ajax()) {
            return $tilesListPage->prepareContent();
        }

        return $tilesListPage;
    }

    /**
     * Prepare Form Page Generator for presentation
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function formPageGenerator(): Dashboard
    {
        $dashboard = new Dashboard();
        $content = view()->file(__DIR__ . '/../../../docs/pages/form-page-generator.md');

        $img = 'https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500';

        $formPageGenerator = (new FormPageGenerator())
            ->title('Page title', 'Page sub-title')
            ->method('POST')    // default POST
            ->action('/')        // default '/'
            ->ajax(true)         // set form to send with Ajax. Default 'true'
            ->input('test_name', 'Submit with custom input', '', 'submit', false, '', [], 'btn btn-default')
            ->hiddenInput('hidden_attribute', null)
            ->textInput('name', null, 'Name', true)
            ->slugInput('slug', 'name', null, 'Slug generated automatically based on name', false, '-', 'lowercase')
            ->numberInput('number', 0, 'Number input', false, 0.01)
            ->emailInput('email', 'tesdt@email.com', 'Email', true)
            ->passwordInput('password', '123', 'Password', true)
            ->colorInput('color', '#000000', 'Select color', false)
            ->checkbox('checkbox_name', false, 'Check me')
            ->switcher('switcher_name', true, 'Switch me')
            // Regular date input
            ->dateInput('date', today(), 'Date', true)
            // Date picker JS
            ->datePickerJS('date_js', today()->format('d-m-Y'), 'Select date with JS', true, ['format' => 'DD-MM-YYYY'], true, true, 2015, 2025, true, false)
            // Date range picker
            ->dateRangePicker('date_range_start', 'date_range_end', today(), today(), 'Select range of dates', true, true, [],true, true, 2015, 2025, true, false, 'Y/d/m')
            // Regular time picker
            ->timeInput('time', now(), 'Time')
            // Time picker with JS
            ->timeOnlyPickerJS('time_js', now(), 'Select time with JS', false, [])
            // Time picker JS
            ->timePickerJS('time_js', now(), 'Select time with JS', false, [], true, true, true, 2015, 2025, false)
            // Regular date and time input
            ->dateTimeInput('date_time', now(), 'DateTime', false)
            // Date and time picker with JS
            ->dateTimePickerJS('date_time_js', now(), 'Select date and time with JS (12h-format without seconds)', false, [], false, false, true, true, 2015, 2025, false)
            // Date and time range picker
            ->dateTimeRangePicker('date_time_range_start', 'date_time_range_end', today(), today(),
                'Select range of dates and times', false, false, [], true, true, true,
                false, 2015, 2025, false)
            // Date range
            ->dateRange('date_range', 'Date range')
            // Regular select
            ->select('select', [1 => 'Option 1', 2 => 'Option 2'], 2, 'Select me', false)
            // Multiply select
            ->select('select', [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'], [1, 3], 'Select me twice', false, true)
            // Regular JS select
            ->selectJS('select', [1 => 'Option 1', 2 => 'Option 2'], 2, 'Select me with JS', false)
            // Multiply JS select with placeholder
            ->selectJS('select', [1 => 'Option 1', 2 => 'Option 2'], '', 'Select with placeholder', false, true, ['data-placeholder' => 'Select option'])
            // JS Select with autocomplete on back-end
            ->selectWithAutocomplete('select', route('dashboard.docs.presentation.select-autocomplete'), [1 => 'London'], 1, 'Search with back-end autocomplete (list of capitals)', false, true)
            ->textarea('comment', '', 'Comment')
            ->visualEditor('content', '<p>test</p>', 'Editor', true) // Additional params can turn on image uploading functionality
            ->fileInput('file', request(), 'File')
            ->imageInput('testImag', $img, 'Image block', '20 Mb', '10', '234', $img, 'myImage.png')
            ->submitButtonTitle('Push me')
            // Add additional button to submit the form with additional params which will be send to backend
            ->addSubmitButton(['redirect' => url('dashboard')], 'Submit and back to dashboard')
            // Add additional link button
            ->addLinkButton(url('/'), 'Go home')
            ->clearButton();

        $formPageGenerator->getForm()->sendAllCheckbox(true);

        $dashboard->page()
            ->setPageTitle('Form Page Generator')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($content)->active()
            ->parent()->addElement()->tab()->title('Example')->content($formPageGenerator->getForm());

        return $dashboard;
    }

    /**
     * Prepare Form Page Generator with Form Group for presentation
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function formPageGeneratorWithFormGroup(): Dashboard
    {
        $dashboard = new Dashboard();
        $content = view()->file(__DIR__ . '/../../../docs/pages/form-page-gen-with-group.md');

        $formPageGeneratorWitFormGroup = (new FormPageGenerator())
//            ->ajax(true, '', '', true)
            ->title('Creating new movement from account to account ')
            ->action(route('dashboard.docs.presentation.custom_success_response'));

        $formPageGeneratorWitFormGroup->getBox()->element()->grid([
            (new Box())
                ->showFullscreenBtn()
                ->boxHeaderContent('<b>From</b>')
                ->content([
                    (new FormGroup())->select('outgoing_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
                    (new FormGroup())->dateInput('outgoing_date', now(), 'Date', true),
                    (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
                    (new FormGroup())->numberInput('outgoing_commission', 0, 'Commission', false, 0.01),
                    (new FormGroup())->select('outgoing_contractor_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Contractor'),
                ]),
            (new Box())
                ->boxHeaderContent('&nbsp')
                ->content([
                    (new FormGroup())->numberInput('rate', 1, 'Rate', true, 0.01),
                    (new FormGroup())->textarea('comment', '', 'Comment', false, ['rows' => 8]),
                ]),
            (new Box())
                ->boxHeaderContent('<b>To</b>')
                ->content([
                    (new FormGroup())->select('incoming_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
                    (new FormGroup())->datePickerJS('incoming_date', now(), 'Date', true, [], false, false, null, null, false, true, 'Y/m/d'),
                    (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
                    (new FormGroup())->numberInput('incoming_commission', 0, 'Commission', false, 0.01),
                    (new FormGroup())->select('incoming_contractor_id', array_prepend([1 => 'Option 1', 2 => 'Option 2'], '', ''), '', 'Contractor'),
                ]),
        ])->lgRowCount(3);

        $formPageGeneratorWitFormGroup->submitButtonTitle('Make transaction and go to it');

        $dashboard->page()
            ->setPageTitle('Form Group')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($content)->active()
            ->parent()->addElement()->tab()->title('Example')->content($formPageGeneratorWitFormGroup->getForm());

        return $dashboard;
    }

    /**
     * @return JsonResponse
     */
    public function customSuccessResponse()
    {
        return response()->json([
            'header' => 'Success header',
            'message' => 'Success message',
        ], 200);
    }

    /**
     * Page for demonstration image displaying components
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function imageDisplaying(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/images.md');

        $img = 'https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500';

        $elFactory = app(ElementsFactory::class);

        $examples = new WrapperDiv([
            new H4Title('by imageInput from FormGenerator'),
            (new FormGenerator())->imageInput('image', $img, 'Image title', '10 Mb'),
            (new H4Title('by imageInput from FormPageGenerator'))->addClass('pt-3'),
            (new FormPageGenerator())->imageInput('image', $img, 'Image title', '10 Mb')->getBox(),
            (new H4Title('Simple image preview by ElementsFactory'))->addClass('pt-3'),
            $elFactory->imagePreview(),
            (new H4Title('Image preview with image'))->addClass('pt-3'),
            $elFactory->imagePreview()
                ->imgUrl($img)
                ->size('100 Mb')
                ->downloadUrl($img),
            (new H4Title('Image input for using inside form'))->addClass('pt-3'),
            $elFactory->imageInput()
                ->addClass('col-6  col-md-4 col-lg-3')
                ->imgUrl($img)
                ->size('10 Mb')->width('50')->height('14')
                ->title('imageInput'),
            (new H4Title('Cool image component'))->addClass('pt-3'),
            $elFactory->imageComponent()
                ->action('/dashboard/tech/uploadAjaxImage')
                ->deleteMethod('DELETE')
                ->deleteAction('/dashboard/tech/deleteAjaxImage')
                ->addClass('col-6 col-md-4 col-lg-3')
                ->imgUrl($img)
                ->size('10 Mb')->width('50')->height('14')
                ->title('imageComponent')
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Images displaying');
    }

    /**
     * JS actions description
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function jsActions(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/js-actions.md');

        $dashboard->page()->addElement()
            ->box()
            ->headerAvailable(false)
            ->content($content);

        return $dashboard;
    }

    /**
     * @param Request $request
     * @return array
     * @throws Throwable
     */
    public function autoComplete(Request $request)
    {
        $foundItems = $this->searchForAutoComplete($request->input('q'));

        return (new SelectJS())->prepareResponseForAutocomplete($foundItems);
    }

    /**
     * @param $searchString
     * @return array|Collection
     */
    protected function searchForAutoComplete($searchString)
    {
        $source = collect($this->getCapitals());

        if (!$searchString) {
            return [];
        }

        return $source->filter(function ($capital) use ($searchString) {
            return false !== stristr($capital, $searchString);
        });
    }

    /**
     * Content auto update demonstration
     *
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function autoUpdate(Dashboard $dashboard)
    {
        $docs = view()->file(__DIR__ . '/../../../docs/js-actions/auto-update.md');

        $button = $this->autoUpdateButton();

        $dashboard->page()
            ->setPageTitle('Auto update element page')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($button->render());

        return $dashboard;
    }

    /**
     * @return DefaultButton
     * @throws NoOneFieldsWereDefined
     */
    public function autoUpdateButton(): DefaultButton
    {
        $icon = new Icon('fa-cog fa-spin');
        $serverTimeStringFormatted = 'Updating button < Server time - ' . now()->format('H:i:s') . ' >';
        $button = new DefaultButton();
        $button->content($icon . $serverTimeStringFormatted);
        $button->js()->contentAutoUpdate()->replaceCurrentElWithContent(route('dashboard.docs.presentation.js-actions.auto-update-button'),
            'GET', 5000);

        return $button;
    }

    public function maskDescription(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__.'/../../../docs/elements/mask-element.md');

        $dashboard->page()
            ->addElement()
            ->box()
            ->addToolsLinkButton(route('dashboard.docs.presentation.mask'),
                'Example',
                '',
                'btn-info'
            )
            ->content($content);

        return $dashboard;
    }

    /**
     * Notifications generation description
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function notificationsDescription(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/notifications.md');

        $examples = new WrapperDiv([
            new H4Title('by Dashboard'),
            $this->notifications((new Dashboard))->page()->notificationArea(),
            new H4Title('by added element on the page'),
            (new Box())->addElement()->notification()
                ->title('Warning!')
                ->text('Warning notification added via the notification method on the box')
                ->button(true)
                ->type('warning')
                ->icon('fas fa-exclamation-circle')
                ->autoHide(true)
                ->autoHideDelay(3),
            new H4Title('by Notification class'),
            (new Notification())
                ->type('danger')
                ->icon('fas fa-ban')
                ->title('Alert!')
                ->content('Danger type alert preview.'),
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Notifications');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     */
    public function mask(Dashboard $dashboard): Dashboard
    {
        $dashboard->addContent($this->makeMaskElement('number', 'Number'));
        $dashboard->addContent($this->makeMaskElement('email', 'Email'));
        $dashboard->addContent($this->makeMaskElement('number2DecPlaces', 'Number with two decimal places'));
        $dashboard->addContent($this->makeMaskElement('dateEuro24', 'European date and time 24h format'));
        $dashboard->addContent($this->makeMaskElement('dateUSA12', 'Date USA and time 12h format'));
        $dashboard->addContent($this->makeMaskElement('time12h', 'Time 12h format'));
        $dashboard->addContent($this->makeMaskElement('time24h', 'Time 24h format'));
        $dashboard->addContent($this->makeMaskElement('dateUSA', 'USA date format'));
        $dashboard->addContent($this->makeMaskElement('dateEuro', 'European date format'));

        return $dashboard;
    }

    /**
     * @param $maskName
     * @param $labelTxt
     * @return FormGroup
     */
    protected function makeMaskElement($maskName, $labelTxt = 'label'): FormGroup
    {
        $element = (new Mask(new Input()))->$maskName();
        $groupElement = (new FormGroup())->labelTxt($labelTxt);
        $groupElement->labelId($element->id)->formGroupContent($element);
        return $groupElement;
    }

    /**
     * Notification examples
     *
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function notifications(Dashboard $dashboard)
    {
        $dashboard->page()
            ->showSuccessNotification('Success!', 'Lorem ipsum')
            ->showInfoNotification('Info!', 'Lorem ipsum', false)
            ->showWarningNotification('Warning!', 'Lorem ipsum', false, true)
            ->showDangerNotification('Danger!', 'Lorem ipsum', false, true, 2);

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function photoUploading(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/photo-uploads.md');

        $loadedPhotos = [
            'https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg',
            config('webmagic.dashboard.dashboard.default_image')
        ];

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->imageArea('photos[]', $loadedPhotos, 'Photo upload', false, true, route('dashboard.docs.presentation.photo-uploading'), route('dashboard.docs.presentation.photo-uploading')),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->imageArea('photos[]', $loadedPhotos, 'Photo upload', false, true, route('dashboard.docs.presentation.photo-uploading'), route('dashboard.docs.presentation.photo-uploading')),
            new H4Title('by PhotoUploader class'),
            (new PhotoUploader())
                ->images('https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg')
                ->addName('photos[]')
                ->required(false)
                ->deleteUrl(route('dashboard.docs.presentation.photo-uploading'))
                ->requestUrl(route('dashboard.docs.presentation.photo-uploading'))

        ]);

        return $this->dashboardPresentation($docs, $example, 'Photo uploads');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function breadcrumbs(): Dashboard
    {
        app(Breadcrumbs::class)->clear();

        $docs = view()->file(__DIR__ . '/../../../docs/elements/breadcrumbs.md');

        $item1 = new \Webmagic\Dashboard\Elements\Breadcrumbs\BreadcrumbsItem('/', 'Index', 'fa-tachometer-alt');
        $item2 = new \Webmagic\Dashboard\Elements\Breadcrumbs\BreadcrumbsItem('/', 'Second element', 'fa-tachometer-alt');

        $examples = new WrapperDiv([
            (new Breadcrumbs())->updateItems($item1, $item2),
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Breadcrumbs');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function mainMenu(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/main-menu-element.md');

        $menuItems = [
            [
                'text' => 'Level 1',
                'icon' => 'fa-circle',
                'link' => url('dashboard'),
                'gates' => ['admin'],
                'active_rules' => [
                    'urls' => [
                        'dashboard'
                    ],
                ]
            ],
            [
                'text' => 'level 2',
                'icon' => 'fa-circle',
                'link' => url('/'),
                'subitems' => [
                    [
                        'text' => 'level 3',
                        'icon' => 'far fa-circle',
                        'link' => url('dashboard/some'),
                        'rank' => 800,
                        'active_rules' => [
                            'urls' => [
                                'dashboard/some'
                            ],
                            'url_reg_exps' => [
                                'dashboard\/some\/.*\/edit'
                            ]
                        ],
                    ],
                    [
                        'text' => 'level 3 second time',
                        'icon' => 'far fa-circle',
                        'link' => url('dashboard/test2'),
                        'rank' => 900,
                        'active_rules' => [
                            'routes' => [
                                'tech::test',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'text' => 'Level 1(second)',
                'icon' => 'fa-book',
                'link' => url('dashboard/test'),
                'rank' => 200,
                'active_rules' => [
                    'routes_parts' => [
                        'tech::',
                        'another::'
                    ],
                ]
            ]
        ];

        $menu1 = new MainMenu($menuItems);

        $item = new Item([
            'text' => 'Item',
            'icon' => 'fa-circle',
            'link' => url('dashboard'),
            'gates' => ['admin'],
            'active_rules' => [
                'urls' => [
                    'dashboard'
                ],
            ]
        ]);

        $menuTree = new \Webmagic\Dashboard\Elements\Menus\MainMenu\Item([
            'text' => 'Tree item',
            'icon' => 'fa-book',
            'link' => url('/')
        ]);

        //set Items as sub item
        $menuTree->addSubItem($item);
        $menuTree->addSubItem($item);

        // Add rules for item
        $item->addRules([
            'routes_parts' => [
                'dashboard::'
            ],
            'routes' => [
                'filter-page'
            ],
            'urls' => [
                'dashboard/test'
            ],
            'url_reg_exps' => [
                'dashboard\/some\/.*\/edit'
            ]
        ]);

        $menu2 = new MainMenu();
        $menu2->addMenuItems($menuItems);
        $menu2->addItem($item);
        $menu2->showSearch(true, url('dashboard/tech/main-menu'), 'search_str');

        $examples = (new WrapperDiv([
            new H4Title('Main Menu just pass an array with next structure'),
            (new WrapperDiv($menu1))->attr('style', 'width: 350px'),
            new H4Title('Main Menu through methods'),
            (new WrapperDiv($menu2))->attr('style', 'width: 350px')
        ]));

        return $this->dashboardPresentation($docs, $examples, 'Main menu');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function topMenu(Dashboard $dashboard)
    {
        $content = view()->file(__DIR__ . '/../../../docs/elements/top-menu-element.md');
        $dashboard->page()
            ->addElement()
            ->box()
            ->boxHeaderContent($this->prepareTopMenuExampleButtons())
            ->content($content);

        return $dashboard;
    }

    /**
     * @return LinkButton[]
     */
    protected function prepareTopMenuExampleButtons(): array
    {
        return [
            $this->prepareTopMenuEnableLiveExampleButton(),
            $this->prepareTopMenuDisableLiveExampleButton(),
        ];
    }

    /**
     * @return LinkButton
     */
    protected function prepareTopMenuEnableLiveExampleButton(): LinkButton
    {
        return (new LinkButton('View Top Menu'))
            ->class('btn btn-success')
            ->link(route('dashboard.docs.presentation.top-menu-presentation-mode'));
    }

    /**
     * @return LinkButton
     */
    protected function prepareTopMenuDisableLiveExampleButton(): LinkButton
    {
        return (new LinkButton('Back To Side Menu'))
            ->class('btn btn-danger')
            ->link(route('dashboard.docs.presentation.top-menu'));
    }

    /**
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function topMenuPresentationMode(): Dashboard
    {
        return $this->topMenu(new Dashboard());
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function adminPanelStyleDescription(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/core/admin-panel-style.md');

        $dashboard->page()->addElement()->box()->makeSimple()->content($content);

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function visualEditor(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/visual-editor.md');

        $examples = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->visualEditor('visual-editor1', 'Some content', 'Visual Editor from FormGroup'),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->visualEditor('visual-editor2', 'Some content', 'Visual Editor from FormGenerator'),
            new H4Title('by FormPageGenerator'),
            (new FormPageGenerator())->visualEditor('visual-editor3', 'Some content', 'Visual Editor from FormPageGenerator')->getBox(),
            new H4Title('Visual editor'),
            (new FormGenerator())->visualEditor(
                'visual',
                'Some content',
                'Visual Editor Example',
            ),
            new H4Title('Visual editor send request on blur'),
            (new FormGenerator())->visualEditor(
                'visual_on_blur',
                '',
                'Visual Editor Example send request on blur',
                false,
                [],
                '',
                route('dashboard.docs.presentation.visual-editor.on-blur'),
                'GET',
                true,
                true
            ),
            new H4Title('Visual editor by VisualEditor class'),
            (new VisualEditor())
                ->content('Some content for visual editor')
                ->title('Title')
                ->name('visual-editor-class')
                ->rows(5)
                ->methodOnBlur('GET')
                ->urlOnBlur(route('dashboard.docs.presentation.visual-editor.on-blur'))
//                ->turnOnFileUpload('my-site.com/route/for-saving-images')
                ->showSuccessMessage()
                ->showErrorMessage()
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Visual Editor');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function visualEditorOnBlur(Request $request): void
    {
        // process
        // $request->input('content')
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function box(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/box.md');

        $items = (new FakeDataService())->forTable(3);

        $box = (new Box())
            ->addBoxTitle('<b>This form can be expanded to full screen </b> ')
            ->addBoxTools((new DefaultButton('Button'))->icon('fa-link')->render())
            ->addBoxBody([
                'content1',
                (new TableGenerator())->items($items),
            ])
            ->addBoxFooter('Footer')
            ->addClass(true)
            ->addBoxBodyClasses('')
            ->addBoxHeaderContent(' <p style="float: left;"><b> - SubTitle in header box</b></p>')
            ->addHeaderAvailable(true)
            ->addFooterAvailable(true)
            ->addColorType(' bg-default')
            ->showFullscreenBtn();

        $box->setToolsLinkButton(route('dashboard.docs.presentation.box'), 'Create', 'fa-plus', 'btn-primary');
        $box->addToolsLinkButton(route('dashboard.docs.presentation.box'), 'Clone', 'fa-clone', 'btn-info');

        $examples = (new FormPageGenerator())->getBox()->content($box);

        return $this->dashboardPresentation($docs, $examples, 'Box');
    }

    /**
     * Flexible DateTime Picker presentation
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function flexibleDateTimePicker(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/flexible-date-time-picker.md');

        $examples = new WrapperDiv([
            new H4Title('by FormGroup with default options'),
            (new FormGroup())->datePickerFlex(
                'flexible_datetime_picker_group',
                now()->subDays(3),
                'by FormGroup label'),
            new H4Title('by FormGenerator with position vertical top and horizontal left'),
            (new FormGenerator())->datePickerFlex(
                'flexible_datetime_picker_generator',
                now(),
                '',
                false,
                [],
                'top',
                'left',
                true,
                'top',
                null,
                null,
                'days'
            ),
            new H4Title('by FormGenerator with show week number and toolbar position bottom'),
            (new FormGenerator())->datePickerFlex(
                'flexible_datetime_picker_generator',
                now(),
                '',
                false,
                [],
                'top',
                'left',
                true,
                'top'
            ),
            new H4Title('by FlexibleDateTimePicker class with set date format d-m-Y'),
            (new FlexibleDateTimePicker())
                ->name('flexible_datetime_picker')
                ->value(now())
                ->horizontalPosition('right')
                ->verticalPosition('bottom')
                ->showWeekNumber(false)
                ->toolbarPosition('top')
                ->minYear(now()->subYears(5)->year)
                ->maxYear(now()->addYears(5)->year)
                ->viewMode('months')
                ->setDateFormat('d-m-Y')
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Flexible Date Time Picker');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function multifieldsSimple(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/multifields/multifields-simple.md');

        $multifieldsSimpleElement = new \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsSimpleElement();
        $multifieldsSimpleElement->maxCopyCount(5);
        $multifieldsSimpleElement->addFields(
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Input())->name('input'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Textarea())->name('textarea'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\DateRange())->name('dateRange'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker())->setDateFormat('Y/m/d')->name('dateTimePicker'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS())->name('selectJS')->options([1,2,3]),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Select)->name('select')->options([1, 2, 3])
        );

        $multifieldsSimpleElement->setData([
            [
                'input' => '1',
                'textarea' => 'textarea1',
                'dateRange' => now(),
                'dateTimePicker' => now()->addDay(),
                'selectJS' => ['a' => 123, 'b', 'c'],
                'select' => ['a' => 456, 'b' => 789, 'c'],
            ],
            [
                'input' => '2',
                'textarea' => 'textarea2',
                'dateRange' => now()->addDays(5),
                'dateTimePicker' => now()->addDays(6),
                'selectJS' => ['c', 'd', 'e'],
                'select' => ['a' => 101112, 'b' => 131415, 'c'],
            ],
        ]);

        $formGenerator = new \Webmagic\Dashboard\Components\FormGenerator();
        $formGenerator->action('/dashboard/tech/multifields-test');
        $formGenerator->getForm()->addContent($multifieldsSimpleElement);
        $formGenerator->addSubmitButton([], 'Submit', 'btn btn-primary float-left ml-2');

        return $this->dashboardPresentation($docs, $formGenerator, 'Multifields simple');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function multifieldsComplex(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/multifields/multifields-complex.md');

        $multifieldsComplexElement = new \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsComplexElement('entity_given_name');
        $multifieldsComplexElement->maxCopyCount(7);
        $multifieldsComplexElement->setAddButtonUrl('/dashboard/tech/multifields-add', 'POST');
        $multifieldsComplexElement->setRemoveButtonUrl('/dashboard/tech/multifields-delete', 'DELETE');

        $multifieldsComplexElement->addFields(
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Input())->name('input'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Textarea())->name('textarea'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\DateRange())->name('dateRange'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker())->setDateFormat('Y/m/d')->name('dateTimePicker'),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS())->name('selectJS')->options([1,2,3]),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Select)->name('select')->options([1,2,3]),
            (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())->name('checkbox')->checked(true)
        );

        $multifieldsComplexElement->setData(
            [
                [
                    'idKey' => 12312312,
                    'input' => '1',
                    'textarea' => 'textarea2',
                    'dateRange' => now(),
                    'dateTimePicker' => now()->addDay(),
                    'selectJS' => ['a' => 123, 'b', 'c'],
                    'select' => ['a' => 456, 'b' => 789, 'c'],
                    'checkbox' => true,
                ],
                [
                    'idKey' => 35435435,
                    'input' => '2',
                    'textarea' => 'textarea2',
                    'dateRange' => now()->addDays(5),
                    'dateTimePicker' => now()->addDays(6),
                    'selectJS' => ['c', 'd', 'e'],
                    'select' => ['a' => 101112, 'b' => 131415, 'c'],
                    'checkbox' => false,
                ],
            ],
            'idKey'
        );

        return $this->dashboardPresentation($docs, $multifieldsComplexElement, 'Multifields complex');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function badge(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/badge.md');

        $example = new WrapperDiv([
            new H4Title('Badge with different colors'),
            (new Badge('Badge'))->addClass('badge-primary'),
            (new Badge('Badge'))->addClass('badge-secondary'),
            (new Badge('Badge'))->addClass('badge-success'),
            (new Badge('Badge'))->addClass('badge-danger'),
            (new Badge('Badge'))->addClass('badge-warning'),
            (new Badge('Badge'))->addClass('badge-info'),
            (new Badge('Badge'))->addClass('badge-light'),
            (new Badge('Badge'))->addClass('badge-dark'),
        ]);

        return $this->dashboardPresentation($docs, $example, 'Badge');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function image(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/image.md');

        $imagePath = asset('/webmagic/dashboard/img/default_logo.png');

        $example = (new WrapperDiv(
            (new Image($imagePath))->alt('Webmagic logo')->attr('data-src', $imagePath)
        ))->addClass('text-center');

        return $this->dashboardPresentation($docs, $example, 'Image');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function lists(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/lists.md');

        $examples = new WrapperDiv([
            new H4Title('DataList'),
            $this->prepareDataList()->addClass('mt-4 mb-4'),
            new H4Title('DescriptionList'),
            $this->prepareDescriptionList()->addClass('mt-4 mb-4'),
            new H4Title('DescriptionList (horizontal)'),
            $this->prepareHorizontalDescriptionList()->addClass('mt-4 mb-4'),
            new H4Title('DescriptionList (align headers by left)'),
            $this->prepareAlignHeadersByLeftDescriptionList()->addClass('mt-4 mb-4'),
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Lists');
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareDataList(): WrapperDiv
    {
        return new WrapperDiv(
            (new DataList([
                'First name' => 'John',
                'Last name' => 'Doe',
                'Age' => '20',
            ]))
        );
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareDescriptionList(): WrapperDiv
    {
        return new WrapperDiv(
            (new DescriptionList([
                'First name' => 'John',
                'Last name' => 'Doe',
                'Age' => '20',
            ]))
        );
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareHorizontalDescriptionList(): WrapperDiv
    {
        return new WrapperDiv(
            (new DescriptionList([
                'First name' => 'John',
                'Last name' => 'Doe',
                'Age' => '20',
            ]))->isHorizontal(true)
        );
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareAlignHeadersByLeftDescriptionList(): WrapperDiv
    {
        return new WrapperDiv(
            (new DescriptionList([
                'First name' => 'John',
                'Last name' => 'Doe',
                'Age' => '20',
            ]))->isHorizontal(true)->setHeadersLeftAlign(true)
        );
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function wrappers(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/wrappers.md');

        $examples = new WrapperDiv([
            new H4Title('WrapperDiv tag DIV'),
            $this->prepareWrapperDivExample()->addClass('mb-3 mt-3'),
            new H4Title('StringElement tag SPAN'),
            $this->prepareStringElementExample()->addClass('mb-3 mt-3'),
            new H4Title('WrapperSpan tag SPAN with icon'),
            $this->prepareWrapperSpanExample()->addClass('mb-3 mt-3'),
            new H4Title('Complex Example'),
            $this->prepareWrappersComplexExample()
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Wrappers');
    }

    /**
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareWrapperDivExample(): WrapperDiv
    {
        return (new WrapperDiv())
            ->attr('some', 'attr')
            ->attrs(['attr1' => 'val1', 'attr2' => 'val2'])
            ->addContent('Simple WrapperDiv')
            ->addClass('text-center border');
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareWrapperSpanExample(): WrapperDiv
    {
        return new WrapperDiv(
            (new WrapperSpan('Simple WrapperSpan'))
                ->addClass('simple_wrapper_span border')
                ->icon('fas fa-snowplow')
        );
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareStringElementExample(): WrapperDiv
    {
        return new WrapperDiv(
            (new StringElement('Simple StringElement'))
                ->addClass('simple_string_element border')
        );
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareWrappersComplexExample(): WrapperDiv
    {
        return (new WrapperDiv([
            (new WrapperDiv([
                (new WrapperDiv([
                    new WrapperDiv(
                        (new WrapperSpan('Left'))
                    ),
                    (new Image())->src(asset('webmagic/dashboard/img/red_pill.png')),
                    (new WrapperSpan('hand'))->addClass('d-block')
                ]))->addClass('col text-danger')->addClass('text-center'),
                (new WrapperDiv([
                    new WrapperDiv(
                        (new WrapperSpan('Right'))
                    ),
                    (new Image())->src(asset('webmagic/dashboard/img/blue_pill.png')),
                    (new WrapperSpan('hand'))->addClass('d-block')
                ]))->addClass('col text-primary')->addClass('text-center'),
            ]))->addClass('row'),
            (new WrapperDiv(
                (new StringElement('You take the blue pill... the story ends, you wake up in your bed and believe whatever you want to believe. You take the red pill... you stay in Wonderland, and I show you how deep the rabbit hole goes.'))
                    ->addClass('col-2 offset-5 font-italic')
            ))->addClass('row')
        ]))->addClass('border');
    }

    /**
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     * @throws FieldUnavailable
     */
    public function tabs(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/tabs.md');

        $image = (new Image('https://picsum.photos/300/200'))->render();
        $tabs1 = (new Tabs())
            ->addTab()->title('Image')->content($image)->active()
            ->parent()->addTab()->title('Lorem Ipsum')->content($this->loremIpsum())
            ->parent();

        $tabs2 = (new Tabs())
            ->addTab()->title('Tab 1')->content($this->loremIpsum())->active()
            ->parent()->addTab()->title('Tab 2')->content($this->loremIpsum())
            ->parent();

        $navigation = $tabs2->getNavigation()->addClass('bg-warning');
        $tabs2->navigation($navigation);

        $example = new WrapperDiv([
            new H4Title('Simple tabs'),
            $tabs1,
            new H4Title('Tabs with changed class for navigation'),
            $tabs2
        ]);

        return $this->dashboardPresentation($docs, $example, 'Tabs');
    }

    /**
     * @return string
     */
    protected function loremIpsum(): string
    {
        return 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.';
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function grid(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/grid.md');

        $example = (new WrapperDiv())
            ->addContent([
                new H4Title('Grids with custom row count'),
                new WrapperSpan('For xs sizes set 1 column:'),
                (new Grid())->xsRowCount(1)->addContent([
                    $this->prepareBox('Form 1'),
                    $this->prepareBox('Form 2'),
                    $this->prepareBox('Form 3'),
                    $this->prepareBox('Form 4'),
                ]),
                new WrapperSpan('For sm sizes set 2 column:'),
                (new Grid())->smRowCount(2)->addContent([
                    $this->prepareBox('Form 5'),
                    $this->prepareBox('Form 6'),
                    $this->prepareBox('Form 7'),
                    $this->prepareBox('Form 8'),
                ]),
                new WrapperSpan('For md sizes set 3 column:'),
                (new Grid())->mdRowCount(3)->addContent([
                    $this->prepareBox('Form 9'),
                    $this->prepareBox('Form 10'),
                    $this->prepareBox('Form 11'),
                    $this->prepareBox('Form 12'),
                ]),
                new WrapperSpan('For lg sizes set 4 column:'),
                (new Grid())->lgRowCount(4)->addContent([
                    $this->prepareBox('Form 13'),
                    $this->prepareBox('Form 14'),
                    $this->prepareBox('Form 15'),
                    $this->prepareBox('Form 16'),
                ]),
                new H4Title('Grid with add class container'),
                (new Grid())->addContent([
                    $this->prepareBox('Form 9'),
                    $this->prepareBox('Form 10'),
                    $this->prepareBox('Form 11'),
                    $this->prepareBox('Form 12'),
                ])->addClass('container'),
                new H4Title('Grid with data before and after grid'),
                (new Grid())->lgRowCount(4)->addContent([
                    $this->prepareBox('Form 17'),
                    $this->prepareBox('Form 18'),
                    $this->prepareBox('Form 19'),
                    $this->prepareBox('Form 20'),
                ])
                    ->beforeGrid('Content before grid')
                    ->afterGrid('Content after grid'),
            ]);

        return $this->dashboardPresentation($docs, $example, 'Grid');
    }

    /**
     * @param string $boxHeader
     * @return Box
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareBox(string $boxHeader = ''): Box
    {
        return (new Box())
            ->showFullscreenBtn()
            ->boxHeaderContent("<b>$boxHeader</b>")
            ->content([
                (new FormGroup())->select('outgoing_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
                (new FormGroup())->dateInput('outgoing_date', now(), 'Date', true),
                (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
                (new FormGroup())->numberInput('outgoing_commission', 0, 'Commission', false, 0.01),
                (new FormGroup())->select('outgoing_contractor_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Contractor'),
            ]);
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function links(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/links.md');

        $example = (new WrapperDiv([
            new H4Title('Link'),
            $this->prepareLinkExample()->addClass('mt-4 mb-4'),
            new H4Title('LinkButton'),
            $this->prepareLinkButtonExample()->addClass('mt-4 mb-4'),
            new H4Title('LinkJSDelete'),
            $this->prepareLinkJSDeleteExample()->addClass('mt-4 mb-4'),
        ]));

        return $this->dashboardPresentation($docs, $example, 'Links');
    }

    /**
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareLinkExample(): WrapperDiv
    {
        return new WrapperDiv(
            (new Link('link to Google search'))
                ->link('https://www.google.com/')
                ->inNewTab()
        );
    }

    /**
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareLinkButtonExample(): WrapperDiv
    {
        return new WrapperDiv(
            (new LinkButton('link button to DuckDuckGo search'))
                ->link('https://duckduckgo.com/')
                ->class('btn-warning')
                ->icon('fa-link')
                ->inNewTab()
        );
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined|FieldUnavailable
     */
    protected function prepareLinkJSDeleteExample(): WrapperDiv
    {
        return (new WrapperDiv([
            (new LinkJSDelete('Remove rectangle'))
                ->requestUri('/')
                ->method('GET')
                ->icon('fa-trash-alt')
                ->itemClass('rectangle')
                ->addClasses(' col-2 d-block btn-danger')
                ->setModalTitle('Rectangle deleting')
                ->setModalContent('Are you sure you want to delete Rectangle?'),
            (new WrapperDiv(
                (new WrapperDiv('Rectangle'))
                    ->addClass('w-25 h-100 border rectangle text-center float-right')
            ))->addClass('col-3 ')
        ]))->addClass('row');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function smallNotificationsDescription(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/core/small-notifications.md');

        $box = new Box($docs);
        $box->headerAvailable(false);
        $box->footerAvailable(false);

        $dashboard->page()
            ->setPageTitle('Notifications')
            ->content($box);

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function progressbar(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/progressbar.md');

        $progressBar = (new ProgressBar())->progress(30);

        $progressBar1 = (new ProgressBar())
            ->title('Progress bar striped with title')
            ->progress(15)
            ->striped(true)
            ->setColorPrimary();

        $progressBar2 = (new ProgressBar())
            ->progress(85)
            ->color('bg-info');

        $progressBar3 = (new ProgressBar())
            ->progress(25)
            ->setColorSuccess()
            ->setThicknessMini();

        $progressBar4 = (new ProgressBar())
            ->progress(45)
            ->setColorDanger()
            ->setThicknessMicro();

        $example = (new WrapperDiv())->addContent([
            new H4Title('Simple progress bar:'),
            $progressBar,
            (new H4Title('Progress bar striped with title:'))->addClass('mt-3'),
            $progressBar1,
            (new H4Title('Progress bar thinnest with custom color (bg-info):'))->addClass('mt-3'),
            $progressBar2,
            (new H4Title('Progress bar of medium thickness with preset green color:'))->addClass('mt-3'),
            $progressBar3,
            (new H4Title('Progress bar of medium thickness with preset red color:'))->addClass('mt-3'),
            $progressBar4,
        ]);

        return $this->dashboardPresentation($docs, $example, 'Progress bar');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws NoOneFieldsWereDefined
     */
    public function blankPageDescription(Dashboard $dashboard): Dashboard
    {
        $content = view()->file(__DIR__ . '/../../../docs/pages/blank-page.md');

        $dashboard->page()
            ->addElement()
            ->box()
            ->addToolsLinkButton(
                route('dashboard.docs.presentation.blank-page-example'),
                'Example',
                '',
                'btn-info'
            )
            ->content($content);

        return $dashboard;
    }

    /**
     * @param Request $request
     * @return BlankPage
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function blankPageDescriptionExample(Request $request): BlankPage
    {
        $blankPage = new BlankPage();
        $blankPage->title('BlankPage example');

        $formGenerator = new FormGenerator();
        $formGenerator
            ->ajax(false)
            ->action(url()->current())
            ->method('GET')
            ->textInput('text_input', '', 'Text input', false, ['placeholder' => 'enter some value'])
            ->submitButton('Submit form');

        $box = new Box();
        $box->headerAvailable(true);
        $box->footerAvailable(true);
        $box->boxHeaderContent(new H4Title('Form'));
        $box->boxFooter('Box footer content');
        $box->addContent($formGenerator);

        $boxForResponse = new Box();
        $boxForResponse->headerAvailable(true);
        $boxForResponse->footerAvailable(false);
        $boxForResponse->boxHeaderContent(new H4Title('Box for response'));
        $boxForResponse->addContent($request->input('text_input', 'Response empty'));

        $blankPage->addContent($box);
        $blankPage->addContent($boxForResponse);

        return $blankPage;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function graphic(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/graphic.md');

        $example = new WrapperDiv([
            new H4Title('Graphic by dataUrl'),
            $this->prepareGraphicExampleByDataUrl('Graphic by dataUrl'),
            new H4Title('Graphic by dataSet'),
            $this->prepareGraphicExampleByDataSet('Graphic by dataSet'),
            new H4Title('Graphic with dummy data'),
            $this->prepareGraphicExampleWithDummyData('Graphic with dummy data'),
            new H4Title('Empty graphic'),
            (new Graphic()),
        ]);

        return $this->dashboardPresentation($docs, $example, 'Graphic');
    }

    /**
     * @param string $title
     * @return Graphic
     */
    protected function prepareGraphicExampleWithDummyData(string $title): Graphic
    {
        return (new Graphic())->fillWithDummyData($title);
    }

    /**
     * @param string $graphicUniqClass
     * @param string $graphicChangeViewUniqClass
     * @param string $graphicFormClass
     * @return Graphic
     */
    protected function prepareGraphic(
        string $graphicUniqClass,
        string $graphicChangeViewUniqClass,
        string $graphicFormClass
    ): Graphic {
        return (new Graphic())
            ->graphicUniqClass($graphicUniqClass)
            ->graphicChangeViewUniqClass($graphicChangeViewUniqClass)
            ->graphicFormClass($graphicFormClass)
            ->isChangeViewAvailable(true)
            ->type('line')
            ->isLegendDisplay(true)
            ->legendPosition('bottom')
            ->pointRadius(10)
            ->lineTension(0.3)
            ->showXAxes(true)
            ->showYAxes(true);
    }

    /**
     * @param string|null $title
     * @return Graphic
     */
    protected function prepareGraphicExampleByDataUrl(string $title): Graphic
    {
        return $this->prepareGraphic(uniqid(), uniqid(), uniqid())
            ->title($title)
            ->dataUrl('http://localhost:8080/dashboard/tech/play/response');
    }

    /**
     * @param string $title
     * @return Graphic
     */
    protected function prepareGraphicExampleByDataSet(string $title): Graphic
    {
        return $this->prepareGraphic(uniqid(), uniqid(), uniqid())
            ->title($title)
            ->labels("January", "February", "March", "April", "May")
            ->addDataSet('label1', [28, 32, 15, 68, 90], '#f56954', '#f56954')
            ->addDataSet('label2', [90, 5, 80, 50, 95]);
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function simpleWidget(): Dashboard
    {
        $dashboard = new Dashboard();
        $docs = view()->file(__DIR__ . '/../../../docs/elements/widget/simple-widget.md');

        $dashboard->page()
            ->setPageTitle('Simple widget')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($this->prepareSimpleWidgetsExample());

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function progressWidget(): Dashboard
    {
        $dashboard = new Dashboard();
        $docs = view()->file(__DIR__ . '/../../../docs/elements/widget/progress-widget.md');

        $dashboard->page()
            ->setPageTitle('Progress widget')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($this->prepareProgressWidgetsExample());

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function boxWidget(): Dashboard
    {
        $dashboard = new Dashboard();
        $docs = view()->file(__DIR__ . '/../../../docs/elements/widget/box-widget.md');

        $dashboard->page()
            ->setPageTitle('Box widget')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($this->prepareBoxWidgetsExample());

        return $dashboard;
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareSimpleWidgetsExample(): WrapperDiv
    {
        $firstExample = (new SimpleWidget())
            ->message('1,410')
            ->title('Messages')
            ->iconBackgroundColor('#17a2b8')
            ->iconColor('#fff')
            ->backgroundColor('#fff')
            ->class('custom_class')
            ->icon('fa-envelope')
            ->textColor('#000');

        $secondExample = (new SimpleWidget())
            ->message('13,648')
            ->title('Uploads')
            ->iconBackgroundColor('#ffc107')
            ->iconColor('#000')
            ->backgroundColor('#fff')
            ->class('custom_class')
            ->icon('fa-copy')
            ->textColor('#000');

        return (new WrapperDiv())
            ->content([$firstExample, $secondExample])
            ->addClass('row');
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareBoxWidgetsExample(): WrapperDiv
    {
        $firstExample = (new BoxWidget())
            ->description('New Orders')
            ->title('150')
            ->textColor('#fff')
            ->backgroundColor('#17a2b8')
            ->class('classes')
            ->icon('fa-shopping-cart')
            ->link('https://www.google.com')
            ->linkTitle('More info')
            ->linkIcon('fa-arrow-circle-right');

        $secondExample = (new BoxWidget())
            ->description('User Registrations')
            ->title('44')
            ->textColor('#000')
            ->backgroundColor('#ffc107')
            ->class('classes')
            ->icon('fa-user-plus')
            ->link('https://www.google.com')
            ->linkTitle('More info')
            ->linkIcon('fa-arrow-circle-right');

        return (new WrapperDiv())
            ->content([$firstExample, $secondExample])
            ->addClass('row');
    }

    /**
     * @return WrapperDiv
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareProgressWidgetsExample(): WrapperDiv
    {
        $firstExample = (new ProgressWidget())
            ->message('41,410')
            ->description('70% Increase in 30 Days')
            ->progress(70)
            ->title('Bookmarks')
            ->textColor('#fff')
            ->iconBackgroundColor('#17a2b8')
            ->backgroundColor('#17a2b8')
            ->class('classes')
            ->icon('fa-bookmark');

        $secondExample = (new ProgressWidget())
            ->message('41,410')
            ->description('70% Increase in 30 Days')
            ->progress(70)
            ->progressColor('#fff')
            ->title('Events')
            ->textColor('#000')
            ->iconBackgroundColor('#ffc107')
            ->backgroundColor('#ffc107')
            ->class('classes')
            ->icon('fa-calendar-alt');

        return (new WrapperDiv())
            ->content([$firstExample, $secondExample])
            ->addClass('row');
    }

    /**
     * @param string $class
     * @return mixed
     */
    protected function margin(string $class = 'pb-3 pt-3')
    {
        return (new WrapperDiv('<hr>'))->addClass($class);
    }

    /**
     * @param \Illuminate\Contracts\View\View $docs
     * @param $example
     * @param string $title
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function dashboardPresentation(\Illuminate\Contracts\View\View $docs, $example, string $title): Dashboard
    {
        $dashboard = new Dashboard();
        $dashboard->page()
            ->setPageTitle($title)
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);

        return $dashboard;
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function passwordInput(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/passwordInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->passwordInput('name', 'some_value', 'Password', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->passwordInput('name', 'some_value', 'Password', false, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('password')->name('name')->value('some_value')->required(false)->attrs([])
        ]);;

        return $this->dashboardPresentation($docs, $example, 'passwordInput');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateInput(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-time/dateInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->dateInput('date', now(), 'Date', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->dateInput('date', now(), 'Date', false, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('date')->name('date')->value(now())->required(false)->attrs([]),
        ]);

        $dashboard->page()
            ->setPageTitle('dateInput')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function timeInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-time/timeInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->timeInput('time', now(), 'Time', false, ['step' => 1]),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->timeInput('time', now(), 'Time', false, ['step' => 1]),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('time')->name('time')->value(now())->required(false)->attrs(['step' => 1]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'timeInput');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateTimePicker(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-time/date-time-picker/date-time-picker.md');

        $dashboard->page()
            ->setPageTitle('dateTimePicker')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active();

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function timePickerJs(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-time/date-time-picker/timePickerJs.md');

        $example = new WrapperDiv([
            (new FormGroup())->timePickerJS('time-picker-js-1', now(), 'Select date time (default)', false, [], true, true, false, null, null, true),
            (new FormGroup())->timePickerJS('time-picker-js-4', now(), "Select date time with 12 hour format", false, [], false, false, false, null, null, true),
            (new FormGroup())->timePickerJS('time-picker-js-2', now(), "Select date time with month and year selection from the list at the top of the calendar", false, [], true, true, true, null, null, true),
            (new FormGroup())->timePickerJS('time-picker-js-3', now(), "Select date time where calendar above input field", false, [], true, true, true, null, null, false),
            (new FormGroup())->timePickerJS('time-picker-js-4', now(), "Select date time with set min and max years", false, [], true, true, true, now()->subYears(3)->year, now()->addYears(3)->year, true),
            (new FormGroup())->timePickerJS('time-picker-js-4', now(), "Select date time without the option to select seconds", false, [], true, false, false, null, null, true),
        ]);

        return $this->dashboardPresentation($docs, $example, 'timePickerJs');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateTimePickerJS(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-time/date-time-picker/dateTimePickerJs.md');

        $example = new WrapperDiv([
            (new FormGroup())
                ->dateTimePickerJS('date-time-picker-js', now(), '(dateTimePickerJS) by FormGroup with default options'),
            (new FormGenerator())
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) without seconds in interface',
                    false, [], true, false, false, false, null, null, true)
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) Select date and time with 12 format',
                    false, [], false)
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) Select date and time with 24 format',
                    false, [], true, false)
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) Select date and time with default ranges',
                    false, [], false, false, true)
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) Select date and time from 2020 to 2030 years',
                    false, [], true, false, false, true, 2020, 2030)
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) Select date and time with default ranges, dropdown with default range of years and months',
                    false, [], false, false, true, true)
                ->dateTimePickerJS('date-time-picker-js', now(),
                    '(dateTimePickerJS) Select date and time open top',
                    false, [], false, false, false, false, null, null, false)
        ]);

        return $this->dashboardPresentation($docs, $example, 'dateTimePickerJS');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateTimeInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-time/date-time-input.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->dateTimeInput('date-time-input', '2022-10-12T12:38:05', 'Date time input', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->dateTimeInput('date-time-input', '2022-10-12T12:38:05', 'Date time input', false, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('datetime-local')->name('date-time-input')->value('2022-10-12T12:38:05')->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'dateTimeInput');
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function select(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/select/select.md');

        $selectData = ['Active', 'Inactive'];
        $selectDataAssoc = ['active' => 'Active', 'inactive' => 'Inactive'];

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->select('select', $selectData, 1, 'Select', false, false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->select('select', $selectDataAssoc, ['active','inactive'], 'Select', false, true, []),
            $this->margin(),
            new H4Title('by Select class'),
            (new Select())
                ->name('select')
                ->options($selectDataAssoc)
                ->selectedKeys(['inactive'])
                ->required(false)
                ->multiple(false)
                ->attrs(['title' => 'Select class'])
        ]);

        $dashboard->page()
            ->setPageTitle('select')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);

        return $dashboard;
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function selectJs(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/select/select-js.md');

        $selectData = ['Active', 'Inactive'];
        $selectDataAssoc = ['active' => 'Active', 'inactive' => 'Inactive'];

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->selectJS('select-js-1', $selectData, 1, 'Select Js', false, false, ['style' => 'width:100%']),
            (new FormGroup())->selectJS('select-js-2', $selectData, 1, 'Select Js with multiple selection', false, true, ['style' => 'width:100%']),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->selectJS('select-js-3', $selectDataAssoc, ['active'], 'Select Js', false, false, ['style' => 'width:100%']),
            (new FormGenerator())->selectJS('select-js-4', $selectDataAssoc, ['active'], 'Select Js with multiple selection', false, true, ['style' => 'width:100%']),
            $this->margin(),
            new H4Title('by SelectJs class'),
            (new SelectJs())
                ->name('select-js-5')
                ->options($selectDataAssoc)
                ->selectedKeys(['inactive'])
                ->required(false)
                ->multiple(false)
                ->attrs(['style' => 'width:100%']),
            (new WrapperDiv())->addClass('mt-3'),
            (new SelectJs())
                ->name('select-js-6')
                ->options($selectDataAssoc)
                ->selectedKeys(['inactive'])
                ->required(false)
                ->multiple(true)
                ->attrs(['style' => 'width:100%']),
            $this->margin(),
            (new FormGenerator())
                ->action(route('dashboard.docs.presentation.select-js-choose-option'))
                ->selectJS('select-js', ['-1' => 'Choose option'] + $selectDataAssoc, null, 'Select Js with required option', false, false, ['style' => 'width:100%'])
                ->submitButton('Send'),
            (new WrapperDiv())->addContent('A little more detailed validation can be seen in the function: \Webmagic\Dashboard\Docs\Http\PresentationController::selectJsChooseOption' )
        ]);

        $dashboard->page()
            ->setPageTitle('selectJs')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);

        return $dashboard;
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function selectWithAutocomplete(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/select/select-with-autocomplete.md');

        $selectData = [1 => 'London', 2 => 'New York'];

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->selectWithAutocomplete(
                'select',
                route('dashboard.docs.presentation.select-autocomplete'),
                [1 => 'London', 2 => 'New York'],
                1,
                'Search with back-end autocomplete',
                false,
                false,
                ['style' => 'width:100%']
            ),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->selectWithAutocomplete(
                'select',
                route('dashboard.docs.presentation.select-autocomplete'),
                [1 => 'London', 2 => 'New York'],
                1,
                'Search with back-end autocomplete',
                false,
                true,
                ['style' => 'width:100%']),
            $this->margin(),
            new H4Title('by SelectJs class'),
            (new SelectJs())
                ->name('select')
                ->options([1 => 'London', 2 => 'New York'])
                ->selectedKeys([1, 2])
                ->required(false)
                ->multiple(true)
                ->attrs(['style' => 'width:100%'])
                ->addAutocomplete(route('dashboard.docs.presentation.select-autocomplete'))
        ]);

        $dashboard->page()
            ->setPageTitle('selectWithAutocomplete')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);

        return $dashboard;
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function textInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/textInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->textInput('name', 'some_value', 'Text input', true),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->textInput('name', 'some_value', 'Text input', true),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('text')->name('name')->value('some_value')->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'textInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function slugInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/slugInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGenerator'),
            (new FormGenerator())
                ->textInput('title', null, 'Title', true)
                ->slugInput('url', 'title', null, 'URl. Slug generated automatically based on title field *', false, '-', 'lowercase'),
        ]);

        return $this->dashboardPresentation($docs, $example, 'slugInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function emailInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/emailInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->emailInput('email', 'email@gmail.com', 'Email input', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->emailInput('email', 'email@gmail.com', 'Email input', false, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('email')->name('email')->value('email@gmail.com')->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'emailInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function numberInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/numberInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->numberInput('name', '12345', 'Number input', false, 1, null, null, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->numberInput('name', '12345', 'Number input', false, 1, null, null, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('number')->name('name')->value('12345')->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'numberInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function input(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/input.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->input('name', 'some_value', 'Text input', 'text', false, 'Text input', [], ' form-control '),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->input('name', 'some_value', 'Number input', 'number', false, 'Number input', [], ' form-control '),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('email')->name('name')->value('email@admin.com')->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'input');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function hiddenInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/hiddenInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            '<p>Hidden input field is hidden and not visible in the form</p>',
            (new FormGroup())->hiddenInput('id', Str::random()),
            $this->margin(),
            new H4Title('by FormGenerator'),
            '<p>Hidden input field is hidden and not visible in the form</p>',
            (new FormGenerator())->hiddenInput('id', Str::random()),
            $this->margin(),
            new H4Title('by Input class'),
            '<p>Hidden input field is hidden and not visible in the form</p>',
            (new Input())->type('hidden')->name('name')->value(Str::random())->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'hiddenInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function fileInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/fileInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->fileInput('name', null, 'File input', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->fileInput('name', null, 'File input', false, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('file')->name('name')->value(null)->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'fileInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function colorInput(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/colorInput.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->colorInput('name', null, 'Color input', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->colorInput('name', null, 'Color input', false, []),
            $this->margin(),
            new H4Title('by Input class'),
            (new Input())->type('color')->name('name')->value(null)->required(false)->attrs(['style' => 'width:100px']),
            $this->margin(),
            new H4Title('by Color class'),
            (new Color())->type('color')->name('name')->value(null)->required(false)->attrs([]),
        ]);

        return $this->dashboardPresentation($docs, $example, 'colorInput');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function textarea(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/textarea.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->textarea('name', '', 'Textarea', false, ['rows' => 5]),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->textarea('name', '', 'Textarea', false, ['rows' => 5]),
            $this->margin(),
            new H4Title('by Textarea class'),
            (new Textarea())->name('name')->content('')->required(false)->class('form-control')->attrs(['rows' => 5])->title('textarea'),
        ]);

        return $this->dashboardPresentation($docs, $example, 'textarea');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function checkbox(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/checkbox.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->checkbox('name', ['name' => true], 'Checkbox', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->checkbox('name', ['name' => true], 'Checkbox', false, []),
            $this->margin(),
            new H4Title('by Checkbox class'),
            (new Checkbox())->name('name')->checked(true)->required(false)->attrs([])
        ]);

        return $this->dashboardPresentation($docs, $example, 'checkbox');
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function switcher(): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/inputs/switcher.md');

        $example = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->switcher('name', ['name' => true], 'Switcher', false, []),
            $this->margin(),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->switcher('name', ['name' => true], 'Switcher', false, []),
            $this->margin(),
            new H4Title('by Switcher class'),
            (new Switcher())->name('name')->checked(true)->required(false)->attrs([])
        ]);

        return $this->dashboardPresentation($docs, $example, 'switcher');
    }

    /**
     * Validation example for selectJs
     * @param Request $request
     * @return void
     */
    public function selectJsChooseOption(Request $request)
    {
        // If the select is required, then you need to change the validation to
        // ['required', 'not_in:-1']
        // and then the user will have to choose some option not different from -1
        $validated = $request->validate([
            'select-js' => ['sometimes'],
        ]);

        // If the select is not required,
        // then the "check" rules are needed in order to have it in the $validated array and then,
        // before checking, exclude it if the value is -1, so that it would not be written to the database.
        if ($validated['select-js'] == '-1') {
            unset($validated['select-js']);
        }

        dd($validated);
    }

    /**
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function middleware(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/core/middleware.md');

        $box = new Box($docs);
        $box->headerAvailable(false);
        $box->footerAvailable(false);

        $dashboard->page()
            ->setPageTitle('Middleware')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active();

        return $dashboard;
    }
}
