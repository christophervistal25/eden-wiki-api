<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Item;
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
            "system",
            "gold",
            "general",
            "charged",
            "ride",
            "housing",
        ];
        foreach ($categories as $category) {
            Category::create(['name' => $category, 'description' => 'Explore more about this category by clicking the button below']);
        }




        $path         = rtrim(app()->basePath('public/all.json'), '/');
        $json         = file_get_contents($path);

        $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($json, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $data = [];
        foreach ($jsonIterator as $key => $val) {
            if (!is_array($val)) {
                if ($key == 'szName') {
                    $data['name'][] = $val;
                } else if ($key == 'szComment') {
                    $data['description'][] = $val;
                } else if ($key == 'dwItemSex') {
                    $data['gender'][] = $val;
                } else if ($key == 'dwLimitLevel1') {
                    $data['level'][] = $val;
                } else if ($key == 'dwItemKind3') {
                    $data['item_kind'][] = $val;
                } else if ($key == 'dwItemKind1') {
                    $data['item_main_kind'][] = $val;
                } else if ($key == 'dwItemJob') {
                    $data['job'][] = $val;
                } else if ($key == 'szIcon') {
                    $data['icon'][] = $val;
                } else if ($key == 'dwAbilityMin') {
                    $data['ability_min'][] = $val;
                } else if ($key == 'dwAbilityMax') {
                    $data['ability_max'][] = $val;
                } else if ($key == 'dwDestParam1') {
                    $data['effect_1_description'][] = $val;
                } else if ($key == 'dwDestParam2') {
                    $data['effect_2_description'][] = $val;
                } else if ($key == 'dwDestParam3') {
                    $data['effect_3_description'][] = $val;
                } else if ($key == 'nAdjParamVal1') {
                    $data['effect_1'][] = $val;
                } else if ($key == 'nAdjParamVal2') {
                    $data['effect_2'][] = $val;
                } else if ($key == 'nAdjParamVal3') {
                    $data['effect_3'][] = $val;
                } else if ($key == 'dwHanded') {
                    $data['handed'][] = $val;
                }
            }
        }
        foreach ($data['name'] as $key => $name) {
            $sub_category = SubCategory::updateOrCreate([
                'name'        => str_replace('_', ' ', $data['item_kind'][$key]),
                'category_id' => Category::where('name', $data['item_main_kind'][$key])->first()->id,
            ]);


            Item::updateOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'name'            => $name,
                    'description'     => $data['description'][$key],
                    'job'             => $data['job'][$key],
                    'gender'          => str_replace("SEX ", '', $data['gender'][$key]),
                    'level'           => (int) $data['level'][$key],
                    'icon'            => $data['icon'][$key],
                    'ability_min'     => (int) $data['ability_min'][$key],
                    'ability_max'     => (int) $data['ability_max'][$key],
                    'effect_1'        => $data['effect_1_description'][$key] . ' : ' . $data['effect_1'][$key],
                    'effect_2'        => $data['effect_2_description'][$key] . ' : ' . $data['effect_2'][$key],
                    'effect_3'        => $data['effect_3_description'][$key] . ' : ' . $data['effect_3'][$key],
                    'handed'          => $data['handed'][$key],
                    'sub_category_id' => $sub_category->id,
                ]
            );
        }
    }
}
