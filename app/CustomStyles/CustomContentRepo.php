<?php

namespace App\CustomStyles;

use Illuminate\Database\Eloquent\Model;
use Webmagic\Core\Entity\EntityRepo;
use Exception;

class CustomContentRepo extends EntityRepo
{
    /**
     * @var string
     */
    protected $entity = CustomContent::class;

    /**
     * @param int $user_id
     * @return Model|null
     * @throws Exception
     */
    public function getByUserID(int $user_id)
    {
        $query = $this->query();
        $query->where('user_id', $user_id);

        return $this->realGetOne($query);
    }
}
