<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ahmad Faiyaz
 * Date: 4/21/2016
 * Time: 12:05 AM
 */


use Illuminate\Database\Seeder;
class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();
        for($i=0; $i <= 20; $i++){
            $a = $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 4000);
            $b = $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 4000);
            DB::table('items')->insert([
                'code' => $faker->word,
                'name'=> $faker->word,
                'description' => $faker->sentence($nbWords = 10, $variableNbWords = true),
                'cost_price' => min($a, $b),
                'selling_price'=> max($a, $b),
            ]);
        }

    }
}