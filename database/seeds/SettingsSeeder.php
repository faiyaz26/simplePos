<?php
/**
 * Created by IntelliJ IDEA.
 * User: ASUS
 * Date: 4/18/2016
 * Time: 3:42 AM
 */
use Illuminate\Database\Seeder;
class SettingsSeeder extends Seeder
{
    public function run()
    {

        $data = array(
            array(
                'key' => 'language',
                'value' => 'en'
            ),
            array(
                'key' => 'siteName',
                'value' => 'Simple-POS'
            ),
            array(
                'key' => 'company',
                'value' => 'Axiara Co.'
            ),
            array(
                'key' => 'receiptHeader',
                'value' => ''
            ),
            array(
                'key' => 'pinCode',
                'value'=> '1234'
            )
        );
        DB::table('settings')->insert($data);
    }
}