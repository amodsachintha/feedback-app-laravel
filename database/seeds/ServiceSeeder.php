<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('feedback_services')
            ->insert([
                'service'=>'අනතුරුදායක ගස් සම්බන්ධ පැමිණිලි',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);

            DB::table('feedback_services')
            ->insert([
                'service'=>'වීදි පහන් සම්බන්ධ පැමිණිලි',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'පරිසර බලපත්‍ර ලබාගැනීම',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'කසල පැමිණිලි',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'වැසිකිළි කාණු සම්බන්ධ ගැටළු',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'ගොඩනැගිළි අයදුම්පත්‍ර අනුමත කිරීම',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'අනුකූලතා සහතික නිකුත් කිරීම',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'ඉඩම් අනුබෙදුම් අනුමත කිරීම',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'වීථි රේඛා සහ නොපවරාගැනීමේ සහතික නිකුත් කිරීම',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'අනවසර ඉදිකිරීම් පැමිණිලි',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'අාපදා කළමනාකරණය',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'මහජන පොළ සහ පොදු වෙළදපල සම්බන්ධ ගැටළු',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'ප්‍රජා සංවර්ධන සමිති',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('feedback_services')
            ->insert([
                'service'=>'වෙනත්',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
    }
}
