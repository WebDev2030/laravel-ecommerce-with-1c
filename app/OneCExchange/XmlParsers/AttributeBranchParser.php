<?php

namespace App\OneCExchange\XmlParsers;

use App\EAV\Models\Attribute;
use App\EAV\Repositories\AttributeRepository;
use App\OneCExchange\Repository;
use App\Repositories\BaseRepository;
use SimpleXMLElement;
use function Doctrine\StaticAnalysis\DBAL\makeMeACustomConnection;

class AttributeBranchParser extends BranchParser
{
    function handle()
    {
        $arStores = $this->parseAttributes($this->xml);
        $this->saveAttributes($arStores);
    }

    function parse()
    {
        $arUnits = [];
        foreach($this->xml->children() as $child){
            /** @var SimpleXMLElement $child */

            $arChild = [
                'external_id' => (string)$child->Ид,
                'active' => !((string)$child->ПометкаУдаления == 'true'),
                'name' => (string)$child->Наименование,
                'type' => $this->getAttributeTypeByNameFrom1C($child->ТипЗначений)
            ];

            $arUnits[] = $arChild;
        }

        return ($arUnits);
    }

    function getRepository(): BaseRepository
    {
        return new AttributeRepository();
    }

    /**
     * Возвращает массив всех разделов
     * @param $xml
     * @param null $parent
     * @return array
     */
    private function parseAttributes($xml): array
    {
        return [];
    }

    private function saveAttributes($arUnits)
    {
        foreach ($arUnits as $arUnit) {
            $this->saveAttribute($arUnit);
        }
    }

    private function saveAttribute($arAttribute): bool
    {
        $attributeRepository = new AttributeRepository();

        if(!($unit = $attributeRepository->getByExternalID($arAttribute['external_id']))) {
            $unit = new Attribute();
        }

        $unit->name = $arAttribute['name'];
        $unit->name_short = $arAttribute['name_short'];
        $unit->code = $arAttribute['code'];
        $unit->international_name = $arAttribute['international_name'];
        $unit->active = $arAttribute['active'];
        $unit->external_id = $arAttribute['external_id'];

        return $unit->save();
    }

    private function getAttributeTypeByNameFrom1C(string $nameFrom1C): string
    {
        return match ($nameFrom1C) {
            'Справочник' => 'dict',
            default => 'string',
        };
    }
}
