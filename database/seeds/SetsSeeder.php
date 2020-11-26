<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Set;

class SetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path =  rtrim(app()->basePath('public/sets.json'), '/');
        $json = file_get_contents($path);
        $descriptions = [
            'IDS_PROPITEMETC_INC_000000' => 'Bravery Set',
            'IDS_PROPITEMETC_INC_000001' => 'Leaf Set',
            'IDS_PROPITEMETC_INC_000002' => 'Parmil Set',
            'IDS_PROPITEMETC_INC_000003' => 'Flower Set',
            'IDS_PROPITEMETC_INC_000004' => 'Petal Set',
            'IDS_PROPITEMETC_INC_000005' => 'Stinger Set',
            'IDS_PROPITEMETC_INC_000006' => 'Slepint Set',
            'IDS_PROPITEMETC_INC_000007' => 'Curus Set',
            'IDS_PROPITEMETC_INC_000008' => 'Sardine Set',
            'IDS_PROPITEMETC_INC_000009' => 'Niz Set',
            'IDS_PROPITEMETC_INC_000010' => 'Seer Set',
            'IDS_PROPITEMETC_INC_000011' => 'Cylos Set',
            'IDS_PROPITEMETC_INC_000012' => 'Comet Set',
            'IDS_PROPITEMETC_INC_000013' => 'Miragle Set',
            'IDS_PROPITEMETC_INC_000014' => 'Layered Set',
            'IDS_PROPITEMETC_INC_000015' => 'Sayram Set',
            'IDS_PROPITEMETC_INC_000016' => 'Talin Set',
            'IDS_PROPITEMETC_INC_000017' => 'Merr Set',
            'IDS_PROPITEMETC_INC_000018' => 'Sorain Set',
            'IDS_PROPITEMETC_INC_000019' => 'Stitch Set',
            'IDS_PROPITEMETC_INC_000020' => 'Panggril Set',
            'IDS_PROPITEMETC_INC_000021' => 'Hyper Set',
            'IDS_PROPITEMETC_INC_000022' => 'Cruiser Set',
            'IDS_PROPITEMETC_INC_000023' => 'Flury Set',
            'IDS_PROPITEMETC_INC_000024' => 'Wedge Set',
            'IDS_PROPITEMETC_INC_000025' => 'Misty Set',
            'IDS_PROPITEMETC_INC_000026' => 'Teba Set',
            'IDS_PROPITEMETC_INC_000027' => 'Recorn set',
            'IDS_PROPITEMETC_INC_000028' => 'Rescorn set',
            'IDS_PROPITEMETC_INC_000029' => 'Rebron set',
            'IDS_PROPITEMETC_INC_000030' => 'Restron set',
            'IDS_PROPITEMETC_INC_000031' => 'Shurand set',
            'IDS_PROPITEMETC_INC_000032' => 'Shuran set',
            'IDS_PROPITEMETC_INC_000033' => 'Ahes set',
            'IDS_PROPITEMETC_INC_000034' => 'Anoos set',
            'IDS_PROPITEMETC_INC_000035' => 'Warpon set',
            'IDS_PROPITEMETC_INC_000036' => 'Warspon set',
            'IDS_PROPITEMETC_INC_000037' => 'Wees set',
            'IDS_PROPITEMETC_INC_000038' => 'Weeshian set',
            'IDS_PROPITEMETC_INC_000039' => 'Extro set',
            'IDS_PROPITEMETC_INC_000040' => 'Ectro set',
            'IDS_PROPITEMETC_INC_000041' => 'Einy set',
            'IDS_PROPITEMETC_INC_000042' => 'Akan set',
            'IDS_PROPITEMETC_INC_000043' => 'Dayst set',
            'IDS_PROPITEMETC_INC_000044' => 'Dest set',
            'IDS_PROPITEMETC_INC_000045' => 'Hanes set',
            'IDS_PROPITEMETC_INC_000046' => 'Haganes set',
            'IDS_PROPITEMETC_INC_000047' => 'Katria set',
            'IDS_PROPITEMETC_INC_000048' => 'Kanarin set',
            'IDS_PROPITEMETC_INC_000049' => 'Restra set',
            'IDS_PROPITEMETC_INC_000050' => 'Rasra set',
            'IDS_PROPITEMETC_INC_000051' => 'Neis set',
            'IDS_PROPITEMETC_INC_000052' => 'Nation set',
            'IDS_PROPITEMETC_INC_000053' => 'Oska set',
            'IDS_PROPITEMETC_INC_000054' => 'Okas set',
            'IDS_PROPITEMETC_INC_000055' => 'Asren set',
            'IDS_PROPITEMETC_INC_000056' => 'Ahren set',
            'IDS_PROPITEMETC_INC_000057' => 'Tyrent set',
            'IDS_PROPITEMETC_INC_000058' => 'Tight set',
            'IDS_PROPITEMETC_INC_000059' => 'Pact set',
            'IDS_PROPITEMETC_INC_000060' => 'Paxt set',
            'IDS_PROPITEMETC_INC_000061' => 'Shupon set',
            'IDS_PROPITEMETC_INC_000062' => 'Shurian set',
            'IDS_PROPITEMETC_INC_000063' => 'Navil set',
            'IDS_PROPITEMETC_INC_000064' => 'Neclus set',
            'IDS_PROPITEMETC_INC_000065' => 'Alex set',
            'IDS_PROPITEMETC_INC_000066' => 'Ales set',
            'IDS_PROPITEMETC_INC_000067' => 'Akent set',
            'IDS_PROPITEMETC_INC_000068' => 'Aken set',
            'IDS_PROPITEMETC_INC_000069' => 'Rody set',
            'IDS_PROPITEMETC_INC_000070' => 'Rodey set',
            'IDS_PROPITEMETC_INC_000071' => 'Ropang set',
            'IDS_PROPITEMETC_INC_000072' => 'Loshuel set',
            'IDS_PROPITEMETC_INC_000073' => 'Geniun set',
            'IDS_PROPITEMETC_INC_000074' => 'Gynas set',
            'IDS_PROPITEMETC_INC_000075' => 'Mekatro set',
            'IDS_PROPITEMETC_INC_000076' => 'Mekaron set',
            'IDS_PROPITEMETC_INC_000077' => 'Myuran set',
            'IDS_PROPITEMETC_INC_000078' => 'Myurian set',
            'IDS_PROPITEMETC_INC_000079' => 'Elder set',
            'IDS_PROPITEMETC_INC_000080' => 'Ellean set',
            'IDS_PROPITEMETC_INC_000081' => 'Shabel set',
            'IDS_PROPITEMETC_INC_000082' => 'Shurian set',
            'IDS_PROPITEMETC_INC_000131' => 'Knighert Set',
            'IDS_PROPITEMETC_INC_000132' => 'Knighz Set',
            'IDS_PROPITEMETC_INC_000133' => 'Blain Set',
            'IDS_PROPITEMETC_INC_000134' => 'Virain Set',
            'IDS_PROPITEMETC_INC_000135' => 'Jesis Set',
            'IDS_PROPITEMETC_INC_000136' => 'Jenes Set',
            'IDS_PROPITEMETC_INC_000137' => 'Ranerz Set',
            'IDS_PROPITEMETC_INC_000138' => 'Raze Set',
            'IDS_PROPITEMETC_INC_000139' => 'Rimyth Set',
            'IDS_PROPITEMETC_INC_000140' => 'Remingster Set',
            'IDS_PROPITEMETC_INC_000141' => 'Billst Set',
            'IDS_PROPITEMETC_INC_000142' => 'Billporon Set',
            'IDS_PROPITEMETC_INC_000143' => 'Psykon Set',
            'IDS_PROPITEMETC_INC_000144' => 'Psyuniper Set',
            'IDS_PROPITEMETC_INC_000145' => 'Ellis Set',
            'IDS_PROPITEMETC_INC_000146' => 'Ellsis Set',
            'IDS_PROPITEMETC_INC_000147' => 'Cruentus (M) Set',
            'IDS_PROPITEMETC_INC_000148' => 'Cruentus (F) Set',
            'IDS_PROPITEMETC_INC_000149' => 'Noctis (M) Set',
            'IDS_PROPITEMETC_INC_000150' => 'Nox (F) Set',
            'IDS_PROPITEMETC_INC_000151' => 'Velox (M) Set',
            'IDS_PROPITEMETC_INC_000152' => 'Velox (F) Set',
            'IDS_PROPITEMETC_INC_000153' => 'Acer (M) Set',
            'IDS_PROPITEMETC_INC_000154' => 'Acer (F) Set',
            'IDS_PROPITEMETC_INC_000155' => 'Revenio (M) Set',
            'IDS_PROPITEMETC_INC_000156' => 'Revenio (F) Set',
            'IDS_PROPITEMETC_INC_000157' => 'Grim (M) Set',
            'IDS_PROPITEMETC_INC_000158' => 'Grim (F) Set',
            'IDS_PROPITEMETC_INC_000159' => 'Twilight (M) Set',
            'IDS_PROPITEMETC_INC_000160' => 'Twilight (F) Set',
            'IDS_PROPITEMETC_INC_000161' => 'Nanemvis (M) Set',
            'IDS_PROPITEMETC_INC_000162' => 'Nanemvis (F) Set',
            'IDS_PROPITEMETC_INC_000163' => 'Bileire Set (M)',
            'IDS_PROPITEMETC_INC_000164' => 'Bilari Set (F)',
            'IDS_PROPITEMETC_INC_000165' => 'Heraud Set (M)',
            'IDS_PROPITEMETC_INC_000166' => 'Herainn Set (F)',
            'IDS_PROPITEMETC_INC_000167' => 'Curio Set (M)',
            'IDS_PROPITEMETC_INC_000168' => 'Curena Set (F)',
            'IDS_PROPITEMETC_INC_000169' => 'Hainure Set (M)',
            'IDS_PROPITEMETC_INC_000170' => 'Hanira Set (F)',
            'IDS_PROPITEMETC_INC_000171' => 'Reine Set (M)',
            'IDS_PROPITEMETC_INC_000172' => 'Rayne Set (F)',
            'IDS_PROPITEMETC_INC_000173' => 'Roenier Set (M)',
            'IDS_PROPITEMETC_INC_000174' => 'Roelayne Set (F)',
            'IDS_PROPITEMETC_INC_000175' => 'Reffiro Set (M)',
            'IDS_PROPITEMETC_INC_000176' => 'Rephira Set (F)',
            'IDS_PROPITEMETC_INC_000177' => 'Lippin Set (M)',
            'IDS_PROPITEMETC_INC_000178' => 'Lypine Set (F)',
            'IDS_PROPITEMETC_INC_000179' => 'Champion\'s Set',
            'IDS_PROPITEMETC_INC_000180' => 'Marksman\'s Set',
            'IDS_PROPITEMETC_INC_000181' => 'Adept\'s Set',
            'IDS_PROPITEMETC_INC_000182' => 'Defender\'s Set',

        ];

        $data = [];
        $jsonData = json_decode($json);

        foreach ($jsonData as $key => $json) {
            foreach ($descriptions as $id => $d) {
                $name = Str::after($json->id_name, "IDS_");
                if ('IDS_' . $name == $id) {
                    $json->id_name = $d;
                }
            }





            // echo  $idd_key . ' => ' . $p . "<br>";
            // echo "________________<br>";
            $data[$key]['name']    = $json->id_name;
            $data[$key]['type']    = $json->type;
            $data[$key]['parts']   = $json->parts[0];
            $data[$key]['effects'] = $json->effects[0];
        }

        foreach ($data as $key => $d) {
            $name = trim(str_replace('(f)', '', str_replace('(m)', '', str_replace('set', '', strtolower($d['name'])))));
            $parts = (array) $d['parts'];

            foreach ($parts as $key => $part) {
                if (Str::contains($part, 'CAP')) {
                    $part = str_replace('CAP', 'HELMET', $part);
                } else if (Str::contains($part, 'UPPER_BODY')) {
                    $part = str_replace('UPPER_BODY', 'SUIT', $part);
                } else if (Str::contains($part, 'HAND')) {
                    $part = str_replace('HAND', 'GAUNLET', $part);
                } else if (Str::contains($part, 'FOOT')) {
                    $part = str_replace('FOOT', 'BOOTS', $part);
                }

                $part = strtoupper($name) . '_' . str_replace("PARTS_", "", $part);
                $parts[$key] = $part;
            }

            Set::create([
                'name'    => $name,
                'type'    => $d['type'],
                'parts'   => json_encode($parts),
                'effects' => json_encode($d['effects']),
            ]);
        }
    }
}
