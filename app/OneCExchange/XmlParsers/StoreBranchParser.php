<?php

namespace App\OneCExchange\XmlParsers;

use App\Catalog\Models\Store;
use App\Catalog\Repositories\PriceTypeRepository;
use App\Catalog\Repositories\StoreRepository;
use App\Repositories\BaseRepositoryInterface;
use SimpleXMLElement;

class StoreBranchParser extends BranchParser
{
    public function parse() {
        $arStores = $this->parseStores($this->xml);
        $this->saveStores($arStores);
    }

    public function getRepository(): BaseRepositoryInterface
    {
        return new PriceTypeRepository();
    }

    /**
     * Возвращает массив всех разделов
     * @param $xml
     * @param null $parent
     * @return array
     */
    private function parseStores($xml): array
    {
        $arStores = [];
        foreach($xml->children() as $child){
            /** @var SimpleXMLElement $child */

            $arChild = [
                'external_id' => (string)$child->Ид,
                'active' => !((string)$child->ПометкаУдаления == 'true'),
                'name' => (string)$child->Наименование,
            ];

            $arStores[] = $arChild;
        }

        return ($arStores);
    }

    private function saveStores($arStores)
    {
        foreach ($arStores as $arStore) {
            $this->saveStore($arStore);
        }
    }

    private function saveStore($arStore): bool
    {
        $storeRepository = new StoreRepository();

        if(!($store = $storeRepository->getByExternalID($arStore['external_id']))) {
            $store = new Store();
        }

        $store->name = $arStore['name'];
        $store->active = $arStore['active'];
        $store->external_id = $arStore['external_id'];

        return $store->save();
    }
}
