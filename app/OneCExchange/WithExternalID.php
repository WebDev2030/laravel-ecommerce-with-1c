<?php

namespace App\OneCExchange;

use Illuminate\Database\Eloquent\Model;

trait WithExternalID
{
    /**
     * @param $externalID
     * @return Model
     */
    function getByExternalID($externalID): Model|null
    {
        return $this->getModel()->where('external_id', $externalID)->limit(1)->first();
    }
}
