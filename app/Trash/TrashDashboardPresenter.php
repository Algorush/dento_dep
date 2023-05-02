<?php

namespace App\Trash;


use App\Deal\Deal;
use App\Users\User;
use Illuminate\Http\Request;
use Webmagic\Dashboard\Components\TableGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\Links\LinkButton;

class TrashDashboardPresenter
{
    /**
     * @param $items
     * @param Request $request
     * @return TableGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getSellersTable($items, Request $request)
    {
        $data['items'] = $request->get('items', 10);
        $data['page'] = $request->get('page', 1);
        $data['keyword'] = $request->get('keyword', '');

        $table = (new TableGenerator())
            ->tableTitles('ID', 'Name', 'Contact', 'Email', 'Deleted At', 'Actions')
            ->showOnly('id', 'name', 'contact_name', 'email', 'deleted_at')
            ->addElementsToToolsCollection(
                function (User $item) {
                    $editBtn = (new LinkButton())
                        ->icon('fas fa-trash-restore')
                        ->class('btn-success btn-sm  js_ajax-by-click-btn')
                        ->dataAttr('action', route('dashboard::trash.restore-user', $item))
                        ->addContent('Restore')->render();

                    $manageClientsBtn = (new LinkButton())
                        ->icon('fas fa-trash')
                        ->content('Real Delete')->class('btn-danger btn-sm js_ajax-by-click-btn pull-left')
                        ->dataAttr('action', route('dashboard::trash.destroy-user', $item))
                        ->dataAttr('method', 'DELETE')
                        ->dataAttr('confirm', true)->render();

                    return '<div style="width:230px;">'.$editBtn.' '.$manageClientsBtn.'</div>';
                }
            )
            ->items($items)
            ->withPagination($items, route('dashboard::trash.sellers', $data));

        $table->addFiltering()
            ->action(route('dashboard::trash.index'))
            ->method('GET')
            ->textInput('keyword', $request->get('keyword' ,''), '', false)
            ->hiddenInput('tab', 'seller')
            ->submitButton('Search');

        return $table;
    }

    /**
     * @param $items
     * @param Request $request
     * @return TableGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getClientsTable($items, Request $request)
    {
        $data['items'] = $request->get('items', 10);
        $data['page'] = $request->get('page', 1);
        $data['keyword'] = $request->get('keyword', '');

        $table = (new TableGenerator())
            ->tableTitles('ID', 'Name', 'Contact', 'Email', 'Seller', 'Deleted At', 'Actions')
            ->showOnly('id', 'name', 'contact_name', 'email', 'seller', 'deleted_at')
            ->setConfig([
                'seller' => function (User $user){
                    return $user->sellerWithTrashed->name ?? '';
                }
            ])
            ->addElementsToToolsCollection(
                function (User $item) {
                    $editBtn = (new LinkButton())
                        ->icon('fas fa-trash-restore')
                        ->class('btn-success btn-sm  js_ajax-by-click-btn')
                        ->dataAttr('action', route('dashboard::trash.restore-user', $item))
                        ->addContent('Restore')->render();

                    $manageClientsBtn = (new LinkButton())
                        ->icon('fas fa-trash')
                        ->content('Real Delete')->class('btn-danger btn-sm js_ajax-by-click-btn pull-left')
                        ->dataAttr('action', route('dashboard::trash.destroy-user', $item))
                        ->dataAttr('method', 'DELETE')
                        ->dataAttr('confirm', true)->render();

                    return '<div style="width:230px;">'.$editBtn.' '.$manageClientsBtn.'</div>';
                }
            )
            ->items($items)
            ->withPagination($items, route('dashboard::trash.clients', $data));

        $table->addFiltering()
            ->action(route('dashboard::trash.index'))
            ->method('GET')
            ->textInput('keyword', $request->get('keyword' ,''), '', false)
            ->hiddenInput('tab', 'client')
            ->submitButton('Search');

        return $table;
    }

    /**
     * @param $items
     * @param Request $request
     * @return TableGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getCasesTable($items, Request $request)
    {
        $data['items'] = $request->get('items', 10);
        $data['page'] = $request->get('page', 1);
        $data['keyword'] = $request->get('keyword', '');

        $table = (new TableGenerator())
            ->tableTitles('ID', 'Case ID', 'Name', 'Client', 'Deleted At', 'Actions')
            ->showOnly('id', 'case_id', 'name', 'client', 'deleted_at')
            ->setConfig([
                'client' => function (Deal $deal){
                    return $deal->clientWithTrashed->name ?? '';
                }
            ])
            ->addElementsToToolsCollection(
                function (Deal $item) {
                    $editBtn = (new LinkButton())
                        ->icon('fas fa-trash-restore')
                        ->class('btn-success btn-sm  js_ajax-by-click-btn')
                        ->dataAttr('action', route('dashboard::trash.restore-case', $item))
                        ->addContent('Restore')->render();

                    $manageClientsBtn = (new LinkButton())
                        ->icon('fas fa-trash')
                        ->content('Real Delete')->class('btn-danger btn-sm js_ajax-by-click-btn pull-left')
                        ->dataAttr('action', route('dashboard::trash.destroy-case', $item))
                        ->dataAttr('method', 'DELETE')
                        ->dataAttr('confirm', true)->render();

                    return '<div style="width:230px;">'.$editBtn.' '.$manageClientsBtn.'</div>';
                }
            )
            ->items($items)
            ->withPagination($items, route('dashboard::trash.cases', $data));

        $table->addFiltering()
            ->action(route('dashboard::trash.index'))
            ->method('GET')
            ->textInput('keyword', $request->get('keyword' ,''), '', false)
            ->hiddenInput('tab', 'case')
            ->submitButton('Search');

        return $table;
    }
}
