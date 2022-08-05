<?php

namespace App\EAV\Repositories;

use App\OneCExchange\WithExternalID;
use App\Repositories\BaseRepository;

class AttributeRepository extends BaseRepository
{
    use WithExternalID;

    protected $model;
}
