<?php

namespace App\Deal;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webmagic\Core\Entity\EntityRepo;
use Exception;

class DealRepo extends EntityRepo
{
    /**
     * @var string
     */
    protected $entity = Deal::class;

    /**
     * @param int $user_id
     * @return Model|null
     * @throws Exception
     */
    public function getByClientID(int $client_id)
    {
        $query = $this->query();
        $query->where('client_id', $client_id);

        return $this->realGetOne($query);
    }

    /**
     * Get all with paginate and filter
     *
     * @param null $keyword
     * @param null $per_page
     * @param null $page
     * @param int|null $client_id
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
        $keyword = null,
        $per_page = null,
        $page = null,
        int $client_id = null,
        int $seller_id = null,
        string $date_from = null,
        string $date_to = null,
        $sortBy = 'created_at',
        $sort = 'desc',
        bool $only_trashed = false
    ) {
        $query = $this->query();

        if ($keyword) {
            $query->where(function ($query) use ($keyword){
                $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('case_id', 'LIKE', '%'.$keyword.'%');
            });
        }

        if ($client_id){
            $query->where('client_id', $client_id);
        }

        if ($seller_id){
            $query->where('seller_id', $seller_id);
        }

        if ($date_from && $date_to){
            $date_from = Carbon::parse($date_from)->toDateTimeString();
            $date_to = Carbon::parse($date_to)->toDateTimeString();

            $query->whereBetween('created_at', [$date_from, $date_to]);
        }

        if ($only_trashed){
            $query->onlyTrashed();
            $query->with('clientWithTrashed');
        } else{
            $query->with('client');
        }

        $query->orderBy($sortBy, $sort);

        if (is_null($per_page) && is_null($page)) {
            return $query->get();
        }

        return $query->paginate($per_page, ['*'], 'page', $page);
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
     * @param string $id
     * @param bool $with_trashed
     * @return Model|null
     * @throws Exception
     */
    public function getByUniqid(string $id, bool $with_trashed = false)
    {
        $query = $this->query();
        $query->where('uniqid', $id);

        if ($with_trashed){
            $query->withTrashed();
        }
        return $this->realGetOne($query);
    }

    /**
     * Get all entities
     *
     * @param null $perPage
     *
     * @param bool $with_trashed
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getAll($perPage = null, bool $with_trashed = false)
    {
        $query = $this->query();

        if ($with_trashed){
            $query->withTrashed();
        }

        return $this->realGetMany($query, $perPage);
    }


    /**
     * Find all items that need be removed (created six months ago)
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getOldForDeleting()
    {
        $query = $this->query();
        $query->whereDate('created_at', '<=', Carbon::now()->subMonths(24)->toDateTimeString());
        return $this->realGetMany($query);
    }

    /**
     * Find all items that will be removed after 14 days
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getOldForNotification()
    {
        $timeForNotification = Carbon::now()->subMonths(24)->addDays(14)->toDateTimeString();

        $query = $this->query();
        $query->whereDate('created_at', '<=', $timeForNotification);
        $query->where('soon_expiration', '!=', true);

        return $this->realGetMany($query);
    }

    /**
     * Get all trash entities that need be removed (deleted two months ago)
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getAlLExpiredTrashed()
    {
        $query = $this->query();

        $query->whereDate('deleted_at', '<=', Carbon::now()->subMonths(2)->toDateTimeString());
        $query->onlyTrashed();

        return $this->realGetMany($query);
    }
}
