<?php

namespace App\CustomStyles;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Webmagic\Core\Entity\EntityRepo;

class CustomStylingRepo extends EntityRepo
{
    /**
     * @var string
     */
    protected $entity = CustomStyling::class;

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
