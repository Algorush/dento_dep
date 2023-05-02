<?php

namespace App\Users;

use App\Users\Roles\RoleRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webmagic\Core\Entity\EntityRepo;

class UserRepo extends EntityRepo
{
    /**
     * @var string
     */
    protected $entity = User::class;

    /**
     * Get all with paginate and filter
     *
     * @param int $role_id
     * @param null $keyword
     * @param null $per_page
     * @param null $page
     * @param int|null $seller_id
     * @param string|null $date_from
     * @param string|null $date_to
     * @param string $sortBy
     * @param string $sort
     * @param bool $only_trashed
     * @return LengthAwarePaginator|Builder[]|Collection
     * @throws Exception
     */
    public function getByFilter(
        int $role_id = null,
        $keyword = null,
        $per_page = null,
        $page = null,
        int $seller_id = null,
        string $date_from = null,
        string $date_to = null,
        $sortBy = 'created_at',
        $sort = 'desc',
        bool $only_trashed = false
    ) {
        $query = $this->query();

        if ($role_id){
            $query->where('role_id', $role_id);
        }

        if ($seller_id){
            $query->where('seller_id', $seller_id);
        }

        if ($keyword) {
            $query->where(function ($query) use ($keyword){
                $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('contact_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('email', 'LIKE', '%'.$keyword.'%');
            });
        }

        if ($date_from && $date_to){
            $date_from = Carbon::parse($date_from)->toDateTimeString();
            $date_to = Carbon::parse($date_to)->toDateTimeString();

            $query->whereBetween('created_at', [$date_from, $date_to]);
        }

        $query->orderBy($sortBy, $sort);

        if ($only_trashed){
            $query->onlyTrashed();
            $query->with('sellerWithTrashed');
        } else {
            $query->with('cases');
        }

        if (is_null($per_page) && is_null($page)) {
            return $query->get();
        }

        return $query->paginate($per_page, ['*'], 'page', $page);
    }

    /**
     * @param string $value
     * @param string $key
     * @param int|null $seller_id
     * @param int|null $role_id
     * @return array
     * @throws Exception
     */
    public function getForSelect($value = 'id', $key = 'id', int $seller_id = null, int $role_id = null): array
    {
        $query = $this->query();

        if ($seller_id) {
            $query->where('seller_id', $seller_id);
        }

        if ($role_id) {
            $query->where('role_id', $role_id);
        }

        if (! $entities = $query->pluck($value, $key)) {
            return $entities->toArray();
        }

        return $entities->toArray();
    }

    /**
     * @param $id
     * @param bool $with_trashed
     * @return Model|null
     * @throws Exception
     */
    public function getByID($id, bool $with_trashed = false)
    {
        $query = $this->query();
        $query->where('id', $id);

        if ($with_trashed){
            $query->withTrashed();
        }
        return $this->realGetOne($query);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getBySellerId(int $id)
    {
        $query = $this->query()->where('seller_id', $id);

        return $this->realGetOne($query);
    }

    /**
     * Get all trash entities that need be removed (deleted two months ago)
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getAlLExpiredTrashedByRole(int $role_id)
    {
        $query = $this->query();

        if ($role_id){
            $query->where('role_id', $role_id);
        }

        $query->whereDate('deleted_at', '<=', Carbon::now()->subMonths(2)->toDateTimeString());
        $query->onlyTrashed();

        return $this->realGetMany($query);
    }

    /**
     * @param string $email
     * @return Model|null
     * @throws Exception
     */
    public function getAccountByEmail(string $email)
    {
        $query = $this->query();
        $query->where('email', $email);

        $client = (new RoleRepo())->getByType('Client');

        $query->where('role_id', '!=', $client->id);

        return $this->realGetOne($query);
    }
}
