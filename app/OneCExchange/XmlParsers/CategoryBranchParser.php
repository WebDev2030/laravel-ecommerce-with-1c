<?php

namespace App\OneCExchange\XmlParsers;

use App\Catalog\Models\Category;
use App\Catalog\Repositories\CategoryRepository;
use App\Helpers\Arr;
use App\OneCExchange\From1CRepositoryInterface;
use App\OneCExchange\Repository;
use SimpleXMLElement;

class CategoryBranchParser extends BranchParser
{
    public function parse() {
        $categories = $this->parseCategories($this->xml);
        $arTree = Arr::buildTree($categories, 0, 'external_id', 'parent_external_id');
        $this->saveCategories($arTree);
    }

    function getRepository(): Repository
    {
        return new CategoryRepository();
    }

    /**
     * Возвращает массив всех разделов
     * @param $xml
     * @param null $parent
     * @return array
     */
    private function parseCategories($xml, $parent = null): array
    {
        $arCategories = [];
        foreach($xml->children() as $child){
            /** @var SimpleXMLElement $child */

            $arChild = [
                'external_id' => (string)$child->Ид,
                'active' => !((string)$child->ПометкаУдаления == 'true'),
                'name' => (string)$child->Наименование,
                'parent_external_id' => is_null($parent) ? 0 : (string)$parent->Ид
            ];

            $arCategories[] = $arChild;

            if(isset($child->Группы)) {
                $arCategories = array_merge($arCategories, $this->parseCategories($child->Группы, $child));
            }
        }

        return ($arCategories);
    }

    private function saveCategories($arTree)
    {
        foreach ($arTree as $arCategory) {
            $this->saveCategory($arCategory);
            if(isset($arCategory['children']) && !empty($arCategory['children'])) {
                $this->saveCategories($arCategory['children']);
            }
        }
    }

    private function saveCategory($arCategory): void
    {
        $categoryRepository = self::getRepository();

        if(!($category = $categoryRepository->getByExternalID($arCategory['external_id']))) {
            $category = new Category();
        }

        $category->name = $arCategory['name'];
        $category->active = $arCategory['active'];
        $category->external_id = $arCategory['external_id'];

        if(isset($arCategory['parent_external_id']) && $arCategory['parent_external_id']) {
            $parent = $categoryRepository->getByExternalID($arCategory['parent_external_id']);
            if($parent) {
                $category->parent = $parent->id;
            }
        }

        $category->save();
    }
}
