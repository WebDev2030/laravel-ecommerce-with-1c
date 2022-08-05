<?php

namespace App\OneCExchange\XmlParsers;

use App\Catalog\Models\PriceType;
use App\Catalog\Repositories\CategoryRepositoryInterface;
use App\Catalog\Repositories\CurrencyRepository;
use App\Catalog\Repositories\PriceTypeRepository;
use App\Repositories\BaseRepositoryInterface;
use SimpleXMLElement;

class PriceTypeBranchParser extends BranchParser
{
    function parse()
    {
        $arPriceTypes = $this->parsePriceTypes($this->xml);
        $this->savePriceTypes($arPriceTypes);
    }

    public function getRepository(): BaseRepositoryInterface
    {
        return new PriceTypeRepository();
    }

    private function parsePriceTypes($xml): array
    {
        $arPriceTypes = [];

        foreach($xml->children() as $child){
            /** @var SimpleXMLElement $child */

            $arChild = [
                'external_id' => (string)$child->Ид,
                'active' => !((string)$child->ПометкаУдаления == 'true'),
                'name' => (string)$child->Наименование,
                'currency' => (string)$child->Валюта,
            ];

            $arPriceTypes[] = $arChild;
        }

        return $arPriceTypes;
    }

    private function savePriceTypes($arPriceTypes) {
        foreach ($arPriceTypes as $arPriceType) {
            $this->savePriceType($arPriceType);
        }
    }

    private function savePriceType($arPrice): bool
    {
        $priceTypeRepository = self::getRepository();
        $currencyRepository = new CurrencyRepository();

        if (!($priceType = $priceTypeRepository->getByExternalID($arPrice['external_id']))) {
            $priceType = new PriceType();
        }

        $currency = $currencyRepository->getByCode($arPrice['currency']);

        $priceType->name = $arPrice['name'];
        $priceType->active = $arPrice['active'];
        $priceType->external_id = $arPrice['external_id'];
        $priceType->currency()->associate($currency);

        return $priceType->save();
    }
}
