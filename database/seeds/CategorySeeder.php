<?php
use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Item;

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

        foreach($categories as $category)
        {
            $cat = Category::create(['name' => $category]);

            
            $path =  rtrim(app()->basePath('public/' . strtolower($category) .'.json'), '/');
            $json = file_get_contents($path); 
            $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($json, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST);
                $data = [];
                foreach ($jsonIterator as $key => $val) {
                    if (!is_array($val)) {
                        if ($key == 'dwID') {
                            $data['id'][] = $val;
                        } else if ($key == 'szName') {
                            $data['name'][]        = explode('|', $val)[0];
                            $data['description'][]= explode('|', $val)[1] ?? '';
                        } else if ($key == 'dwItemSex') {
                            $data['gender'][] = $val;
                        } else if ($key == 'dwLimitLevel1') {
                            $data['level'][] = $val;
                        } else if($key == 'dwItemKind3') {
                            $data['item_kind'][] = $val;
                        }
                        else if ($key == 'dwItemJob') {
                            $data['job'][] = $val;		
                        }
                        // echo $key . '=>' . $val . '<br>';
                    }
                }
                    foreach ($data['id'] as $key => $id) {
                        Item::updateOrCreate(
                            ['equip_id' => $id],
                            [
                                'equip_id'    => $id,
                                'category_id' => $cat->id,
                                'name'        => $data['name'][$key],
                                'description' => $data['description'][$key],
                                'job'         => $data['job'][$key],
                                'gender'      => $data['gender'][$key],
                                'level'       => $data['level'][$key],
                                'kind'   => $data['item_kind'][$key],
                        ]);
                    }

        }
    }
}
