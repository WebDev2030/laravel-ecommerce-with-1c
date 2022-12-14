<?php

namespace App\Catalog\Repositories;

use App\Catalog\Models\PriceType;
use App\OneCExchange\WithExternalIDTrait;
use App\Repositories\BaseRepository;


class PriceTypeRepository extends BaseRepository implements PriceTypeRepositoryInterface
{
    /**
     * @var class-string
     */
    protected $model = PriceType::class;
}
