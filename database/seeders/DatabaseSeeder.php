<?php

namespace Database\Seeders;

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
        $this->call(BanksTableSeeder::class);
        $this->call(AccountsTableSeeder::class);

        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(ParishesTableSeeder::class);

        $this->call(CategoriesTableSeeder::class);
        $this->call(LeaguesTableSeeder::class);
        // $this->call(BetTypesTableSeeder::class);
        $this->call(EventTypesTableSeeder::class);
        $this->call(MatchStructuresTableSeeder::class);

        $this->call(ConfigurationTableSeeder::class);

        $this->call(RacecoursesTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(PlayersTableSeeder::class);
    }
}
