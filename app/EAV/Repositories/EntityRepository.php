<?php

namespace App\EAV\Repositories;

use App\EAV\Models\Entity;
use App\OneCExchange\DTO;
use App\OneCExchange\WithExternalIDTrait;
use App\Repositories\BaseRepository;

class EntityRepository extends From1CRepository implements EntityRepositoryInterface
{
    /**
     * @var class-string
     */
    protected $model = Entity::class;

    public function storeFrom1C(DTO\Base $data)
    {
        // TODO: Implement storeFrom1C() method.
    }
}
