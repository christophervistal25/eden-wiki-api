<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Set;
use App\Models\SubCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "weapon",
            "armor",
            "fashion",
            "system",
            "gold",
            "general",
            "accesories",
            "ride",
            "pets",
            "cards",
            "housing",
            "etc",
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }




        $path         = rtrim(app()->basePath('public/all.json'), '/');
        $json         = file_get_contents($path);

        $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($json, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($jsonIterator as $key => $val) {
            if (is_array($val)) {
                // echo "Load : " . $val['dwItemKind1'] . ' => ' . $val['dwItemKind3'] . "\n";
                $sub_category = SubCategory::updateOrCreate([
                    'name'        => str_replace('_', ' ', $val['dwItemKind3']),
                    'category_id' => Category::where('name', $val['dwItemKind1'])->first()->id,
                ]);

                $exploded = explode(" ", $val['szName']);
                $itemName = $exploded[0];

                // $set = Set::where('name', strtolower($itemName))->first();
                $set = null;

                if (!is_null($set)) {

                    $item = Item::updateOrCreate(
                        [
                            'name' => $val['szName']
                        ],
                        [
                            'name'            => $val['szName'],
                            'description'     => $val['szComment'],
                            'job'             => $val['dwItemJob'],
                            'gender'          => str_replace("SEX ", '', $val['dwItemSex']),
                            'level'           => (int) $val['dwLimitLevel1'],
                            'icon'            => $val['szIcon'],
                            'ability_min'     => (int) $val['dwAbilityMin'],
                            'ability_max'     => (int) $val['dwAbilityMax'],
                            'effect_1'        => $val['dwDestParam1'] . ' : ' . $val['nAdjParamVal1'],
                            'effect_2'        => $val['dwDestParam2'] . ' : ' . $val['nAdjParamVal2'],
                            'effect_3'        => $val['dwDestParam3'] . ' : ' . $val['nAdjParamVal3'],
                            'handed'          => $val['dwHanded'],
                            'sub_category_id' => $sub_category->id,
                        ]
                    );

                    // confirm if the item is belongs to a set.
                    if (trim($set->type) == trim($item->sub_category->category->name)) {
                        $set->items()->save($item);
                    }
                } else {
                    Item::updateOrCreate(
                        [
                            'name' => $val['szName']
                        ],
                        [
                            'name'            => $val['szName'],
                            'description'     => $val['szComment'],
                            'job'             => $val['dwItemJob'],
                            'gender'          => str_replace("SEX ", '', $val['dwItemSex']),
                            'level'           => (int) $val['dwLimitLevel1'],
                            'icon'            => $val['szIcon'],
                            'ability_min'     => (int) $val['dwAbilityMin'],
                            'ability_max'     => (int) $val['dwAbilityMax'],
                            'effect_1'        => $val['dwDestParam1'] . ' : ' . $val['nAdjParamVal1'],
                            'effect_2'        => $val['dwDestParam2'] . ' : ' . $val['nAdjParamVal2'],
                            'effect_3'        => $val['dwDestParam3'] . ' : ' . $val['nAdjParamVal3'],
                            'handed'          => $val['dwHanded'],
                            'sub_category_id' => $sub_category->id,
                        ]
                    );
                }
            }
        }
    }
}
