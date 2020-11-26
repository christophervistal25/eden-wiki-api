<?php

namespace App\Http\Controllers\Repository;

use App\Models\Item;
use App\Models\Set;


class SetPart
{
    private $baseItem;
    private $noOfSets;
    private const PREFIX = 'II';
    private const SEPERATOR = '_';


    public function __construct()
    {
        $this->noOfSets = Set::count() + 1;
    }

    public function createUsingThis(array $items): array
    {
        $parts = [];
        foreach ($items as $item) {
            $this->setBaseItem($item->id);
            $parts[$this->generateKey()] = $this->getName();
        }
        return $parts;
    }

    private function setBaseItem($item)
    {
        $this->baseItem = Item::find($item);
    }

    public function getBaseItem(): Item
    {
        return $this->baseItem;
    }

    private function getName(): string
    {
        return str_replace(' ', self::SEPERATOR, strtoupper($this->baseItem->name));
    }

    /**
     * Convert to uppercase
     * Get the first letter of job
     */
    private function getJob(): string
    {
        return strtoupper(substr($this->baseItem->job, 0, 3));
    }

    /**
     * Get only the first letter of gender.
     */
    private function getGender(): string
    {
        return strtoupper($this->baseItem->gender[0]);
    }

    /** 
     * Get the type of the item 
     * e.g (HELMET, GAUNLET)
     */
    private function getSubCategory(): string
    {
        return strtoupper($this->baseItem->sub_category->name);
    }

    public function getCategory(): string
    {
        return strtoupper(substr($this->baseItem->sub_category->category->name, 0, 3));
    }

    private function generateKey(): string
    {
        return  self::PREFIX . self::SEPERATOR .  $this->getCategory() . self::SEPERATOR . $this->getGender()  . '_' . $this->getJob() . self::SEPERATOR . $this->getSubCategory() . self::SEPERATOR . $this->noOfSets;
    }
}
