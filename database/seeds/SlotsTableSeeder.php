<?php

use Illuminate\Database\Seeder;

class SlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();
        $days  = \App\Day::all();

        $slotsData = [];

        foreach($days as $day) {
            // By mieć dobre dane do testów wymuszam puste wtorki
            if($day->name === 'Tuesday') {
                continue;
            }

            foreach($users as $user) {
                // 10% wyników
                if(rand(1, 10) === 1) {
                    continue;
                }

                $slotsData[] = factory(App\Slot::class)->create([
                    'day_id'  => $day->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
