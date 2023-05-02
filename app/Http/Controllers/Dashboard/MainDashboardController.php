<?php

namespace App\Http\Controllers\Dashboard;

use App\Deal\DealRepo;
use App\Http\Controllers\Controller;
use App\Users\Roles\RoleRepo;
use App\Users\UserRepo;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;


class MainDashboardController extends Controller
{
    /**
     * @param Dashboard $dashboard
     * @param RoleRepo $roleRepo
     * @param DealRepo $dealRepo
     * @param UserRepo $userRepo
     * @param Request $request
     * @return Application|Factory|View|Dashboard
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function index(
        Dashboard $dashboard,
        RoleRepo $roleRepo,
        DealRepo $dealRepo,
        UserRepo $userRepo,
        Request $request
    ) {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $roles = $roleRepo->getAll();

            $sellerRole = $roles->where('name', 'Seller')->first();
            $clientRole =  $roles->where('name', 'Client')->first();
            $date_from = $request->get('date_from', null);
            $date_to = $request->get('date_to', null);
            $seller_id = $request->get('seller_id', null);

            $allCases = $dealRepo->getByFilter(null, null, null, null, $seller_id,
                $date_from,
                $date_to,
            );
            $allSellers = $userRepo->getByFilter($sellerRole->id, null, null, null, null,
                $date_from,
                $date_to,
            );
            $allClients = $userRepo->getByFilter($clientRole->id, null, null, null, $seller_id,
                $date_from,
                $date_to,
            );
            $cases = null;
            $clients = null;

            $sellersForSelect = $userRepo->getForSelect('name', 'id', null, $sellerRole->id);
        } else {
            $allCases = $user->casesBySeller;
            $allClients = $user->clients;
            $allSellers = null;
            $cases = $allCases->sortByDesc('created_at')->take(5);
            $clients = $allClients->sortByDesc('created_at')->take(5);
            $sellersForSelect = null;
        }

        if ($request->ajax()) {
            return view('dashboard._info_boxes', compact('allSellers','allClients', 'allCases', 'date_from', 'date_to', 'sellersForSelect', 'seller_id'));
        }

        $dashboard->page()
            ->addContentHeader("<h1>Dashboard</h1>")
            ->addContent(
                view('dashboard.main', compact(
                    'user',
                    'cases',
                    'clients',
                    'allCases',
                    'allClients',
                    'allSellers',
                    'sellersForSelect'
                ))
            );

        return $dashboard;
    }

}
