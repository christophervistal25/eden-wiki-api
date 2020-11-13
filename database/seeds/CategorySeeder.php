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
        $categories = ['Armors', 'Charges', 'Generals', 'Golds', 'Housings', 'Rides', 'Systems', 'Weapons'];

        foreach ($categories as $category) {
            $cat = Category::create(['name' => $category]);


            $path =  rtrim(app()->basePath('public/' . strtolower($category) . '.json'), '/');
            $json = file_get_contents($path);
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($json, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST
            );
            $data = [];
            foreach ($jsonIterator as $key => $val) {
                if (!is_array($val)) {
                    if ($key == 'dwID') {
                        $data['id'][] = $val;
                    } else if ($key == 'szName') {
                        $data['name'][]        = explode('|', $val)[0];
                        $data['description'][] = explode('|', $val)[1] ?? '';
                    } else if ($key == 'dwItemSex') {
                        $data['gender'][] = $val;
                    } else if ($key == 'dwLimitLevel1') {
                        $data['level'][] = $val;
                    } else if ($key == 'dwItemKind3') {
                        $data['item_kind'][] = $val;
                    } else if ($key == 'dwItemJob') {
                        $data['job'][] = $val;
                    }
                    // echo $key . '=>' . $val . '<br>';
                }
            }

            foreach ($data['id'] as $key => $id) {
                $sub_category = SubCategory::updateOrCreate([
                    'name' =>   str_replace('_', ' ', str_replace('IK3_', '', $data['item_kind'][$key])),
                    'category_id' => $cat->id
                ]);
                Item::updateOrCreate(
                    [
                        'name' => $data['name'][$key]
                    ],
                    [
                        'equip_id'        => $id,
                        'name'            => trim(str_replace('@', ' ', $data['name'][$key])),
                        'description'     => $data['description'][$key],
                        'job'             => str_replace('JOB_', '', $data['job'][$key]),
                        'gender'          => str_replace('SEX_', '', $data['gender'][$key]),
                        'level'           => (int) $data['level'][$key],
                        'sub_category_id' => (int) $sub_category->id,
                    ]
                );
            }
        }
    }
}
