<?php

namespace App\Catalog\Repositories;

use App\Catalog\Models\Unit;
use App\OneCExchange\WithExternalIDTrait;
use App\Repositories\BaseRepository;


class UnitRepository extends BaseRepository implements UnitRepositoryInterface
{
    /**
     * @var class-string
     */
    protected $model = Unit::class;
}
