<?php

namespace App\OneCExchange;

use App\BaseDTO;
use App\EAV\Models\Entity;
use App\OneCExchange\DTO\Attribute;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

abstract class Repository extends BaseRepository
{
    protected Entity $entity;

    /**
     * @param $externalID
     * @return Model
     */
    function getByExternalID($externalID): Model|null
    {
        return $this->getModel()->where('external_id', $externalID)->limit(1)->first();
    }
}
