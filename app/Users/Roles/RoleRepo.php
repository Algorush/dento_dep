<?php

namespace App\Users\Roles;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Webmagic\Core\Entity\EntityRepo;

class RoleRepo extends EntityRepo
{
    protected $entity = Role::class;

    /**
     * @param string $name
     * @return Model|null
     * @throws Exception
     */
    public function getByType(string $name)
    {
        $query = $this->query();

        $query->where('name', $name);

        return $this->realGetOne($query);
    }

    /**
     * Get all entities
     *
     * @param null $perPage
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getAll($perPage = null)
    {
        $query = $this->query();

        $query->with('users');

        return $this->realGetMany($query, $perPage);
    }
}
