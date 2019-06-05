<?php

namespace Modules\Feedback\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedbackDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        if (DB::table('app_settings')->whereKey('email_support')->count() < 1){
            DB::table('app_settings')->insert([
                [
                    'key' => 'support_email'
                    , 'value' => 'sheleh121@gmail.com'
                ]
            ]);
            $this->command->info('Настройка "email_support" создана!');
        }
        else $this->command->info('Настройка "email_support" существует!');
    }
}
