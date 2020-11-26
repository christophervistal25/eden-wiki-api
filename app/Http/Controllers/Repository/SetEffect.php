<?php

namespace App\Http\Controllers\Repository;

class SetEffect
{
    private const SEPERATOR = '_';
    // ATTRIBUTE|NO_OF_PARTS : VALUE OF ATTRIBUTE
    public function createUsingThis(array $itemEffects)
    {
        $effects = [];

        foreach ($itemEffects as $effect) {
            list($noOfPartsRequire) = explode('/', $effect->no_of_parts);
            $key =  $this->generateKey($noOfPartsRequire, $effect->attribute);
            $effects[$key] = $effect->attribute_value;
        }

        return $effects;
    }

    private function generateKey($partsRequire, $attribute): string
    {
        return strtoupper($attribute) . self::SEPERATOR . $partsRequire;
    }
}
