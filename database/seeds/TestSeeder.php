<?php

use App\Deal\Deal;
use App\Users\Roles\Role;
use App\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSellers();
        $this->createCases();
    }

    public function createSellers()
    {
        $role_client = Role::where('name', 'Client')->first();

        factory(User::class, 10)->create()->each(function ($seller) use ($role_client) {

            $seller->clients()->saveMany(
                factory(User::class, rand(1, 5))->make([
                    'role_id' => $role_client->id,
                    'seller_id' => $seller->id,
                ])
            );
        });
    }

    public function createCases()
    {
        $role_client = Role::where('name', 'Client')->first();
        $clients = User::where('role_id', $role_client->id)->get();

        foreach ($clients as $client){
            $client->cases()->saveMany(
                factory(Deal::class, rand(1, 2))->make([
                    'client_id' => $client->id,
                    'seller_id' => $client->seller_id,
                ])
            );
        }
    }
}
