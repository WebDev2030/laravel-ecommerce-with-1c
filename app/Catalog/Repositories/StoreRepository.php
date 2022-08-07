<?php

namespace App\Catalog\Repositories;

use App\Catalog\Models\Store;
use App\OneCExchange\WithExternalIDTrait;
use App\Repositories\BaseRepository;


class StoreRepository extends BaseRepository implements PriceTypeRepositoryInterface
{
    /**
     * @var class-string
     */
    protected $model = Store::class;
}
