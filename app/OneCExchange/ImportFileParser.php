<?php

namespace App\OneCExchange;

use App\EAV\Models\Entity;
use App\EAV\Repositories\EntityRepository;
use App\OneCExchange\XmlParsers\AttributeBranchParser;
use App\OneCExchange\XmlParsers\BranchHandlerFactory;
use App\OneCExchange\XmlParsers\BranchParserInterface;
use App\OneCExchange\XmlParsers\CategoryBranchParser;
use App\OneCExchange\XmlParsers\PriceTypeBranchParser;
use App\OneCExchange\XmlParsers\StoreBranchParser;
use App\OneCExchange\XmlParsers\UnitBranchParser;
use SimpleXMLElement;

class ImportFileParser
{
    /**
     * @var string
     */
    private $filpath = '';
    private $entity;
    private SimpleXMLElement $xml;

    public function __construct(string $filepath)
    {
        $this->filpath = $filepath;
    }

    public function parse()
    {
        $this->xml = simplexml_load_file($this->filpath);
        $this->parseXml();
    }

    public function parseXml()
    {
        $this->getEntity();

        foreach($this->xml->Классификатор->children() as $childName => $child){
            $branchParser = self::getBranchParserByName($childName, $child);
            if($branchParser) {
                $result = $branchParser->parse();
                $rep = $branchParser->getRepository();
//                $rep->setEntity($this->entity);

                foreach ($result as $item) {
                    $rep->storeFrom1C($item);
                }
            }
        }
    }

    public function getEntity()
    {
//        $this->entity = (new EntityRepository)->getByExternalID($this->xml->Ид);
//        if(!$this->entity) {
//            $entity = new Entity();
//        }
//        $entity->name = $this->xml->Наименование;
//        $entity->save();
    }

    public static function getBranchParserByName($branchName, $xml): BranchParserInterface|null
    {
        return match ($branchName) {
//            'Группы' => new CategoryBranchParser($xml),
//            'ТипыЦен' => new PriceTypeBranchParser($xml),
//            'Склады' => new StoreBranchParser($xml),
//            'ЕдиницыИзмерения' => new UnitBranchParser($xml),
            'Свойства' => new AttributeBranchParser($xml),
            default => null,
        };
    }
}
