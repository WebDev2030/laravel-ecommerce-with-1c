<?php

namespace App\OneCExchange\XmlParsers;

abstract class BranchParser implements BranchParserInterface
{
    protected \SimpleXMLElement $xml;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }
}
