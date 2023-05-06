<?php

namespace Webmagic\Dashboard\Services;

use Faker\Generator;

class FakeDataService
{
    /**
     * @param int $amountRows
     * @return array
     */
    public function forTable(int $amountRows = 10): array
    {
        /** @var Generator $faker */
        $faker = app(Generator::class);
        $data = [];
        for ($i = 0; $i < $amountRows; $i++) {
            $data[] = [
                'id'      => $faker->numberBetween(0, 100),
                'name'    => $faker->name,
                'address' => $faker->address,
            ];
        }

        return $data;
    }
}