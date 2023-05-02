<?php

namespace App\Trash;

use App\Deal\DealRepo;
use App\Deal\DealService;
use App\Users\Roles\RoleRepo;
use App\Users\UserRepo;
use App\Users\UserService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Laracasts\Presenter\Exceptions\PresenterException;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;

class TrashService
{
    /**
     * @var DealRepo
     */
    protected $dealRepo;

    /**
     * @var UserRepo
     */
    private $userRepo;

    /**
     * @var DealService
     */
    private $dealService;

    /**
     * @var RoleRepo
     */
    private $roleRepo;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * DealService constructor.
     *
     * @param DealRepo $dealRepo
     * @param DealService $dealService
     * @param UserRepo $userRepo
     * @param UserService $userService
     * @param RoleRepo $roleRepo
     */
    public function __construct(
        DealRepo $dealRepo,
        DealService $dealService,
        UserRepo $userRepo,
        UserService $userService,
        RoleRepo $roleRepo
    ) {
        $this->dealRepo = $dealRepo;
        $this->dealService = $dealService;
        $this->userRepo = $userRepo;
        $this->userService = $userService;
        $this->roleRepo = $roleRepo;
    }

    /**
     * Find cases, clients and sellers that were removed two months ago
     * and force delete them
     *
     * @throws Exception
     */
    public function cleanAllExpiredItems()
    {
        $deals = $this->dealRepo->getAlLExpiredTrashed();
        $this->cleanDeals($deals);

        $roles = $this->roleRepo->getAll();
        $sellerRole = $roles->where('name', 'Seller')->first();
        $clientRole =  $roles->where('name', 'Client')->first();

        $sellers = $this->userRepo->getAlLExpiredTrashedByRole($sellerRole->id);
        $this->cleanUsers($sellers);

        $clients = $this->userRepo->getAlLExpiredTrashedByRole($clientRole->id);
        $this->cleanUsers($clients);
    }

    /**
     * @param Collection $deals
     * @throws PresenterException
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    protected function cleanDeals(Collection $deals)
    {
        if ($deals->count()) {
            foreach ($deals as $deal) {
                $this->dealService->realDestroy($deal);
            }
        }
    }

    /**
     * @param Collection $users
     * @throws PresenterException
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    protected function cleanUsers(Collection $users)
    {
        if ($users->count()){
            foreach ($users as $user){
                $this->userService->realDestroy($user);
            }
        }
    }


}
