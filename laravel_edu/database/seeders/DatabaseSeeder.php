<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // 개별 시더 실행 : php artisan db:seed --class=파일명
        // 더미 데이터 삽입용 팩토리 호출 : 보통은 5000 ~ 10000단위로 루프를 돌림
        $cnt = 0;
        while($cnt < 60){
            \App\Models\Board::factory(10)->create();
            $cnt++;
        }
    }
}
