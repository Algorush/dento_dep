<?php

namespace App\Users;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Components\TablePageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Forms\Form;
use Webmagic\Dashboard\Elements\Links\LinkButton;

class UserDashboardPresenter
{

    /**
     * @param $items
     * @param Dashboard $dashboard
     * @param Request $request
     * @return mixed|Dashboard
     * @throws NoOneFieldsWereDefined
     * @throws FieldUnavailable
     */
    public function getSellersTablePage($items, Dashboard $dashboard, Request $request)
    {
        $data['items'] = $request->get('items', 10);
        $data['page'] = $request->get('page', 1);
        $data['keyword'] = $request->get('keyword', '');

        $tablePageGenerator = (new TablePageGenerator($dashboard->page()))
            ->title('Sellers')
            ->tableTitles('Company', 'Company Contact', 'Company Email', 'Actions')
            ->showOnly('name', 'contact_name', 'email')
            ->addElementsToToolsCollection(
                function (User $item) {
                    $editBtn = (new LinkButton())
                        ->icon('fas fa-edit')
                        ->link(route('dashboard::sellers.edit', $item))
                        ->class('btn-info btn-sm')
                        ->addContent('Edit')->render();

                    $manageClientsBtn = (new LinkButton())
                        ->icon('fas fa-users')
                        ->link(route('dashboard::clients.index', $item))
                        ->class('btn-warning btn-sm')
                        ->addContent('Manage Clients')->render();

                    $casesBySellerBtn = (new LinkButton())
                        ->icon('fas fa-eye')
                        ->link(route('dashboard::deals.index-by-seller', $item))
                        ->class('btn-primary btn-sm')
                        ->addContent('View Cases')->render();

                    return '<div style="width:300px;">'.$editBtn.' '.$manageClientsBtn.' '. $casesBySellerBtn .'</div>';
                }
            )
            ->items($items)
            ->withPagination($items, route('dashboard::sellers.index', $data))
            ->createLink(route('dashboard::sellers.create'))
        ;

        $tablePageGenerator->addFiltering()
            ->action(route('dashboard::sellers.index'))
            ->method('GET')
            ->textInput('keyword', $request->get('keyword' ,''), '', false)
            ->submitButton('Search');

        if ($request->ajax()) {
            return $dashboard->page()->content()->toArray()['box_body'];
        }

        return $dashboard;
    }

    /**
     * @param Dashboard $dashboard
     * @param string $user_type
     * @param int|null $seller_id
     * @return Dashboard
     */
    public function getCreateUserForm(Dashboard $dashboard, string $user_type, int $seller_id = null)
    {
        if($user_type == 'Client'){
            $routeCreate = route('dashboard::clients.store');
            $password = false;
        } else {
            $routeCreate = route('dashboard::sellers.store');
            $password = true;
        }

        return $this->prepareCreateFormWithPartsByEditorType(
            $user_type,
            $password,
            $routeCreate,
            $seller_id,
            $dashboard
        );
    }

    /**
     * @param $user_type
     * @param $password
     * @param $routeCreate
     * @param $seller_id
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareCreateFormWithPartsByEditorType($user_type, $password, $routeCreate, $seller_id, Dashboard $dashboard)
    {
        $details_form = (new FormGenerator())
            ->textInput('name', false, "$user_type Name", true)
            ->textInput('contact_name', false, 'Contact Name', true)
            ->emailInput('email', false, 'Contact Email', true);

        //Add seller id for creating clients
        if ($seller_id){
            $details_form->hiddenInput('seller_id', $seller_id);
        }

        if(Auth::user()->isAdmin()) {

            //Add password for seller
            if($password){
                $details_form->passwordInput('password', false, 'New Password', true)
                    ->passwordInput('password_confirmation', false, 'Confirm New Password', true);
            }

            $details_form->imageInput('logo', '', "$user_type Logo")
                ->numberInput('logo_width', false, 'Logo Width (px)', false, '1')
                ->numberInput('logo_height', false, 'Logo Height (px)', false, '1');

            //styling sector
            $styling_form = (new FormGenerator())
                ->textInput('primary_color', false, 'Primary Colour')
                ->textInput('header_color', false, 'Header Background Colour')
                ->textInput('body_color', false, 'Body Background Colour')
                ->textInput('text_color', false, 'Text Colour')
                ->textInput('background_color', false, 'Loading Screen Background Colour')
                ->textInput('progressbar_color', false, 'Progressbar Process Colour')
                ->textInput('progressbar_background_color', false, 'Progressbar Background Colour');

            //custom sector
            $content_form = (new FormGenerator())
                ->textInput('point_text_header_1', false, 'How to wear your Aligners')
                ->textInput('point_text_header_2', false, 'Wear Sсhedule')
                ->textInput('point_text_header_3', false, 'Treatment Duration')
                ->textInput('point_text_header_4', false, 'Patient')
                ->imageInput('point_image_1', '', 'Point 1 Image')
                ->textarea('point_text_1', false, 'Point 1 Text')
                ->imageInput('point_image_2', '', 'Point 2 Image')
                ->textarea('point_text_2', false, 'Point 2 Text')
                ->imageInput('point_image_3', '', 'Point 3 Image')
                ->textarea('point_text_3', false, 'Point 3 Text')
                ->imageInput('point_image_4', '', 'Point 4 Image')
                ->textarea('point_text_4', false, 'Point 4 Text')

                //Custom css and pdf file
                ->textarea('custom_css', false, 'Custom Css')
                ->fileInput('pdf', false, 'Pdf');
        }

        $form = (new Form())
            ->addElement()->box()->addBoxHeaderContent("$user_type Details")
            ->content($details_form->getForm()->getViewData()['form_content']->render())
            ->footerAvailable(false)
            ->parent();

        if(Auth::user()->isAdmin()) {
            $form ->addElement()->box()->addBoxHeaderContent('Styling')
                ->content($styling_form->getForm()->getViewData()['form_content']->render())
                ->footerAvailable(false)
                ->parent()
                ->addElement()->box()->addBoxHeaderContent('Custom Content')
                ->content($content_form->getForm()->getViewData()['form_content']->render())
                ->footerAvailable(false)
                ->parent();
        }

        $form = $form->addClass(' js-submit clearfix')
            ->action($routeCreate)
            ->method('POST')
            ->addElement()->button()->type('submit')->class(' btn btn-primary float-right ml-2')
            ->content('Create')->parent();

        $dashboard->page()->setPageTitle("Add $user_type")->addContent($form);

        return $dashboard;
    }


    /**
     * @param Model $user
     * @param string $user_type
     * @return FormPageGenerator|Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getEditUserForm(Model $user, string $user_type, Dashboard $dashboard)
    {
        if($user_type == 'Client'){
            $routeUpdate =route('dashboard::clients.update', $user);
            $routeDestroy = route('dashboard::sellers.destroy', $user);
            $password = false;
        } else {
            $routeUpdate = route('dashboard::sellers.update', $user);
            $routeDestroy = route('dashboard::sellers.destroy', $user);
            $password = true;
        }

        return  $this->prepareEditFormWithPartsByEditorType(
            $user,
            $user_type,
            $password,
            $routeUpdate,
            $routeDestroy,
            $dashboard
        );
    }

    /**
     * Edit form by admin fro seller or client
     *
     * @param $user
     * @param $user_type
     * @param $password
     * @param $routeUpdate
     * @param $routeDestroy
     * @param Dashboard $dashboard
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareEditFormWithPartsByEditorType(
        $user,
        $user_type,
        $password,
        $routeUpdate,
        $routeDestroy,
        Dashboard $dashboard
    ) {
        $details_form = (new FormGenerator())
            ->textInput('name', $user, "$user_type Name", true)
            ->textInput('contact_name', $user, 'Contact Name', true)
            ->emailInput('email', $user, 'Contact Email', true);

        if(Auth::user()->isAdmin()) {

            //Add password for seller
            if($password){
                $details_form->passwordInput('password', false, 'New Password')
                    ->passwordInput('password_confirmation', false, 'Confirm New Password');
            }

            $details_form->imageInput('logo', $user->logo ? $user->present()->logo : '', "$user_type Logo")
                ->numberInput('logo_width', $user->logo_width, 'Logo Width (px)', false, '1')
                ->numberInput('logo_height', $user, 'Logo Height (px)', false, '1');

            //styling sector
            $styling_form = (new FormGenerator())
                ->textInput('primary_color', $user->customStyling, 'Primary Colour')
                ->textInput('header_color', $user->customStyling, 'Header Background Colour')
                ->textInput('body_color', $user->customStyling, 'Body Background Colour')
                ->textInput('text_color', $user->customStyling, 'Text Colour')
                ->textInput('background_color', $user->customStyling, 'Loading Screen Background Colour')
                ->textInput('progressbar_color', $user->customStyling, 'Progressbar Process Colour')
                ->textInput('progressbar_background_color', $user->customStyling, 'Progressbar Background Colour');;

            if ($user->customContent){
                $image1 = $user->customContent->present()->image_1 ?? '';
                $image2 = $user->customContent->present()->image_2 ?? '';
                $image3 = $user->customContent->present()->image_3 ?? '';
                $image4 = $user->customContent->present()->image_4 ?? '';
            }
            
            //custom sector
            $content_form = (new FormGenerator())
                ->textInput('point_text_header_1', $user->customContent, 'How to wear your Aligners')
                ->textInput('point_text_header_2', $user->customContent, 'Wear Sсhedule')
                ->textInput('point_text_header_3', $user->customContent, 'Treatment Duration')
                ->textInput('point_text_header_4', $user->customContent, 'Patient')
                ->imageInput('point_image_1', $image1 ?? '', 'Point 1 Image')
                ->textarea('point_text_1', $user->customContent, 'Point 1 Text')
                ->imageInput('point_image_2', $image2 ?? '', 'Point 2 Image')
                ->textarea('point_text_2', $user->customContent, 'Point 2 Text')
                ->imageInput('point_image_3', $image3 ?? '', 'Point 3 Image')
                ->textarea('point_text_3', $user->customContent, 'Point 3 Text')
                ->imageInput('point_image_4', $image4 ?? '', 'Point 4 Image')
                ->textarea('point_text_4', $user->customContent, 'Point 4 Text')

                //Custom css and pdf file
                ->textarea('custom_css', $user, 'Custom Css')
                ->fileInput('pdf', false, 'Pdf');

            if($user->pdf){
                $name = last(explode('_', $user->pdf));
                $content_form->checkbox('delete_pdf_file', false, "Delete uploaded file (current file: $name)");
            }
        }

        $form = (new Form())
            ->addElement()->box()->addBoxHeaderContent("$user_type Details")
            ->content($details_form->getForm()->getViewData()['form_content']->render())
            ->footerAvailable(false)
            ->parent();

        if(Auth::user()->isAdmin()) {
            $form ->addElement()->box()->addBoxHeaderContent('Styling')
                ->content($styling_form->getForm()->getViewData()['form_content']->render())
                ->footerAvailable(false)
                ->parent()
                ->addElement()->box()->addBoxHeaderContent('Custom Content')
                ->content($content_form->getForm()->getViewData()['form_content']->render())
                ->footerAvailable(false)
                ->parent();
        }

        $form = $form->addClass(' js-submit')
            ->action($routeUpdate)
            ->method('PUT')
            ->addElement()->button()->type('submit')->class(' btn btn-primary float-right ml-2')
            ->content('Update')->parent();

        $dashboard->page()->setPageTitle("$user_type editing")->addContent($form);

        if(Auth::user()->isAdmin()) {
            $dashboard->page()->addElement()->linkButton()->icon('fas fa-trash')
                ->content('Delete')
                ->class('btn-danger js_ajax-by-click-btn pull-left')
                ->dataAttr('action', $routeDestroy)
                ->dataAttr('method', 'DELETE')
                ->dataAttr('confirm', true);
        }

        return $dashboard;
    }

    /**
     * @param $seller_id
     * @param $items
     * @param Dashboard $dashboard
     * @param Request $request
     * @return mixed|Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getClientsTablePage($seller_id, $items, Dashboard $dashboard, Request $request)
    {
        $data['seller_id'] = $seller_id;
        $data['items'] = $request->get('items', 10);
        $data['page'] = $request->get('page', 1);
        $data['keyword'] = $request->get('keyword', '');

        $tablePageGenerator = (new TablePageGenerator($dashboard->page()))
            ->title('Clients')
            ->tableTitles('Client Name', 'Client Contact', 'Cases', 'Actions')
            ->showOnly('name', 'contact_name', 'cases')
            ->setConfig([
                'cases' => function (User $item) {
                    return $item->cases->count();
                },
            ])
            ->addElementsToToolsCollection(
                function (User $item) {
                    $editBtn = (new LinkButton())
                        ->icon('fas fa-edit')
                        ->link(route('dashboard::clients.edit', $item))
                        ->class('btn-info btn-sm')
                        ->addContent('Edit')->render();

                    $manageClientsBtn = (new LinkButton())
                        ->icon('fas fa-eye')
                        ->link(route('dashboard::deals.index-by-client', $item))
                        ->class('btn-primary btn-sm')
                        ->addContent('View Cases')->render();

                    return '<div style="width:230px;">'.$editBtn.' '.$manageClientsBtn.'</div>';
                }
            )
            ->items($items)
            ->withPagination($items, route('dashboard::clients.index', $data))
            ->createLink(route('dashboard::clients.create', $seller_id))
        ;

        $tablePageGenerator->addFiltering()
            ->action(route('dashboard::clients.index', $seller_id))
            ->method('GET')
            ->textInput('keyword', $request->get('keyword' ,''), '', false)
            ->submitButton('Search');

        if ($request->ajax()) {
            return $dashboard->page()->content()->toArray()['box_body'];
        }

        return $dashboard;
    }

    /**
     * @param Model|User $user
     * @return FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getEditAccountForm(Model $user)
    {
        $formPageGenerator = (new FormPageGenerator())
            ->title("My Account Editing")
            ->action(route('dashboard::account.update', $user))
            ->method('PUT');

        if ($user->isAdmin()){
            $formPageGenerator->emailInput('email', $user, 'Email', true);
        } else{
            $formPageGenerator->textInput('name', $user, "Company Name", true)
                ->textInput('contact_name', $user, 'Contact Name', true)
                ->emailInput('email', $user, 'Contact Email', true);
        }
        $formPageGenerator->passwordInput('password', false, 'New Password')
            ->passwordInput('password_confirmation', false, 'Confirm New Password');


        return $formPageGenerator->submitButtonTitle('Update');
    }
}
