<?php

namespace App\Deal;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Components\TableGenerator;
use Webmagic\Dashboard\Components\TablePageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Boxes\Box;
use Webmagic\Dashboard\Elements\Forms\Form;
use Webmagic\Dashboard\Elements\Links\LinkButton;

class DealDashboardPresenter
{
    /**
     * @param int|null $seller_id
     * @param int|null $client_id
     * @param $items
     * @param Dashboard $dashboard
     * @param Request $request
     * @return mixed|Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getDealsTablePage(int $seller_id = null, int $client_id = null, $items, Dashboard $dashboard, Request $request)
    {
        $data['items'] = $request->get('items', 10);
        $data['page'] = $request->get('page', 1);
        $data['keyword'] = $request->get('keyword', '');

        if($seller_id){
            $routeName = 'dashboard::deals.index-by-seller';
            $routeCreate = 'dashboard::deals.create-by-seller';
            $data['seller_id'] = $seller_id ?? null;
            $title = "Cases by seller";
        } else {
            $routeName = 'dashboard::deals.index-by-client';
            $routeCreate = 'dashboard::deals.create-by-client';
            $data['client_id'] = $client_id ?? null;
            $title = "Cases by client";
        }
        $tablePageGenerator = (new TablePageGenerator($dashboard->page()))
            ->title($title)
            ->tableTitles('Case ID', 'Customer Name', 'Client', 'Actions')
            ->showOnly('case_id', 'name', 'client')
            ->setConfig([
                'client' => function (Deal $item) {
                    return $item->client->name ?? $item->seller->name;
                },
            ])
            ->addElementsToToolsCollection(
                function (Deal $item) {
                    $editBtn = (new LinkButton())
                        ->icon('fas fa-edit')
                        ->link(route('dashboard::deals.edit', $item))
                        ->class('btn-info btn-sm')
                        ->addContent('Edit')->render();

                    $viewBtn = (new LinkButton())
                        ->icon('fas fa-eye')
                        ->link($item->present()->routeForCaseView())
                        ->class('btn-primary btn-sm')
                        ->attr('target', '_blank')
                        ->addContent('View')->render();

                    $copyUrlBtn = (new LinkButton())
                        ->icon('fas fa-copy')
                        ->link($item->present()->routeForCaseView())
                        ->class('btn-primary btn-sm js_copy-link')
                        ->addContent('Copy URL')->render();

                    return '<div style="width:230px;">'.$editBtn.'      '.$viewBtn.' '.$copyUrlBtn.'</div>';
                }
            )
            ->items($items)
            ->withPagination($items, route($routeName, $data))
            ->createLink(route($routeCreate, $seller_id ?? $client_id))
        ;

        $tablePageGenerator->addFiltering()
            ->action(route($routeName, $seller_id ?? $client_id))
            ->method('GET')
            ->textInput('keyword', $request->get('keyword' ,''), '', false)
            ->submitButton('Search');

        $copyScript = view('dashboard._copy_url_btn');

        $dashboard->page()->addFooter($copyScript);

        if ($request->ajax()) {
            return $dashboard->page()->content()->toArray()['box_body'];
        }

        return $dashboard;
    }

    /**
     * @param array $clients
     * @param int $seller_id
     * @param int|null $client_id
     * @return FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getCreateForm(array $clients, int $seller_id, int $client_id = null)
    {
        $wear_schedule_text = "Wear Schedule (Duration in days the patient needs to wear the aligners for)";
        $treatment_text = "Days or Nights (Please select day time or night time aligners)";
        $form = (new FormPageGenerator())
            ->title("Add Case")
            ->action(route('dashboard::deals.store'))
            ->ajax(true)
            ->method('POST')
            ->select('client_id', $clients, $client_id, "Allocated Client", true)
            ->textInput('case_id', false, 'Case Id', true)
            ->hiddenInput('seller_id', $seller_id)
            ->textInput('name', false, 'Customer Name', true)
            ->numberInput('wear_count', 14, $wear_schedule_text, true)
            ->select('wear_times_of_day', [1 => 'Days', 2 => 'Nights'], 1, $treatment_text, true)
            ->fileInput('pdf', false, 'Pdf')
            ->fileInput('ipr', false, 'IPR')
            ->imageArea('upper_files[]', [], 'Upper Files');

        $form->getForm()->getViewData()['form_content']->addContent(
            view('dashboard._position_inputs_in_line', [
                'title' => 'Upper',
                'field_prefix' => 'upper',
            ])
        );
        $form->imageArea('lower_files[]', [], 'Lower Files');
        $form->getForm()->getViewData()['form_content']->addContent(
            view('dashboard._position_inputs_in_line',[
                'title' => 'Lower',
                'field_prefix' => 'lower',
            ])
        );

        return $form->submitButtonTitle("Add Case");
    }

    /**
     * @param Dashboard $dashboard
     * @param Model $deal
     * @param array $clients
     * @param string|null $active_tab
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getEditForm(Dashboard $dashboard, Model $deal, array $clients, string $active_tab = null)
    {
        $wear_schedule_text = "Wear Schedule (Duration in days the patient needs to wear the aligners for)";
        $treatment_text = "Days or Nights (Please select day time or night time aligners)";
        $main_form = (new FormGenerator())
            ->select('client_id', $clients, $deal, "Allocated Client", true)
            ->textInput('case_id', $deal, 'Case Id', true)
            ->textInput('name', $deal, 'Customer Name', true)
            ->numberInput('wear_count', $deal, $wear_schedule_text, true)
            ->select('wear_times_of_day', [1 => 'Days', 2 => 'Nights'], $deal->wear_times_of_day, $treatment_text, true)
            ->fileInput('pdf', false, 'Pdf');            

        if($deal->pdf){
            $name = last(explode('_', $deal->pdf));
            $main_form->checkbox('delete_pdf_file', false, "Delete uploaded file (current file: $name)");
        }

        $input1 = view('dashboard._position_inputs_in_line', [
            'title' => 'Upper',
            'field_prefix' => 'upper',
            'value1' => $deal->upper_position_x,
            'value2' => $deal->upper_position_y,
            'value3' => $deal->upper_rotation_y,
        ]);
        $input2 = view('dashboard._position_inputs_in_line', [
            'title' => 'Lower',
            'field_prefix' => 'lower',
            'value1' => $deal->lower_position_x,
            'value2' => $deal->lower_position_y,
            'value3' => $deal->lower_rotation_y,
        ]);

        $main_form->fileInput('ipr', false, 'IPR');

        if($deal->ipr){
            $nameIPR = last(explode('_', $deal->ipr));
            $main_form->checkbox('delete_ipr_file', false, "Delete uploaded file (current file: $nameIPR)");
        }
        $upper_box = $this->getTableOfFilesByType('upper', $deal);
        $lower_box = $this->getTableOfFilesByType('lower', $deal);

        $form = (new Form())
            ->addElement()->tabs()
            ->addTab()->title('Details')->active($active_tab ? false : true)
            ->content($main_form->getForm()->getViewData()['form_content']->render(). $input1. $input2)
            ->parent('tabs')
            ->addElement('tabs')->tab()->active($active_tab == 'upper' ? true : false)
            ->title('Upper Files')
            ->content($upper_box->render())
            ->parent('tabs')
            ->addElement('tabs')->tab()->active($active_tab == 'lower' ? true : false)
            ->title('Lower Files')
            ->content($lower_box->render())
            ->parent('tabs')
            ->parent();

        $form = $form->addClass(' js-submit')
            ->action(route('dashboard::deals.update', $deal))
            ->method('PUT')
            ->addElement()->button()->type('submit')->class(' btn btn-primary float-right ml-2')
            ->content('Update')->parent();

        $dashboard->page()->setPageTitle("Case editing")->addContent($form);

        if(Auth::user()->isAdmin()) {
            $dashboard->page()->addElement()->linkButton()->icon('fas fa-trash')
                ->content('Delete')
                ->class('btn-danger js_ajax-by-click-btn float-left')
                ->dataAttr('action', route('dashboard::deals.destroy', $deal))
                ->dataAttr('method', 'DELETE')
                ->dataAttr('confirm', true);
        }
        return $dashboard;
    }

    /**
     * @param string $type
     * @param Model|Deal $deal
     * @return mixed
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function getTableOfFilesByType(string $type, Model $deal)
    {
        if ($type == 'upper'){
            $items = $deal->upperFiles;
            $title = 'Upper';
        } else {
            $items = $deal->lowerFiles;
            $title = 'Lower';
        }

        $filesTable = (new TableGenerator())
            ->tableTitles('ID', 'File', '')
            ->showOnly('id', 'file')
            ->setConfig([
                'file' => function ($item) use ($deal){
                    return $item->original_name;
                },
            ])
            ->items($items)
            ->setDestroyLinkClosure(function ($item) use ($type){
                return route('dashboard::deals.destroy-file', [$type, $item]);
            })
            ->manualSorting(route('dashboard::deals.position-file', $type), function ($item) {return $item['id'];}, 'POST');

        return (new Box())
            ->element('box_tools')
            ->linkButton()
            ->content("Add $title File")
            ->icon('fas fa-plus ')
            ->class('pull-right btn btn-flat btn-default js_ajax-by-click-btn')
            ->dataAttr('action', route('dashboard::deals.add-file', [$deal, $type]))
            ->dataAttr('modal', 'true')
            ->dataAttr('method', 'GET')
            ->dataAttr('modal-ttl', "Add $title File")->parent()
            ->addContent($filesTable);
    }

    /**
     * @param int $deal_id
     * @param string $type
     * @return FormGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getUpperOrLowerFileInputInPopup(int $deal_id, string $type)
    {
        if ($type == 'upper'){
            $input = 'upper_file';
            $title = 'Upper';
        } else {
            $input = 'lower_file';
            $title = 'Lower';
        }

        return (new FormGenerator())
            ->action(route('dashboard::deals.save-file', [$deal_id, $type]))
            ->ajax(true)
            ->method('POST')
            ->fileInput($input, '', "$title File Input", true)
            ->submitButton('Save');
    }

}
