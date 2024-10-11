<?php

namespace Database\Factories;

use App\Models\Code;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CodeFactory extends Factory
{
    protected $model = Code::class;

    public function definition()
    {
        return [
            //'code' => $this->generateCode(),
            'code' => Str::upper(fake()->bothify('????-####-????')),
            'consumed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'guest_id' => null,
            'created_at' => now(),
            'host_id'=>User::factory(),
        ];
    }
    private function generateCode(): string
    {
        $part1 = strtoupper($this->faker->lexify('????'));

        $part2 = $this->faker->numerify('###');

        $part3 = strtoupper($this->faker->lexify('????'));

        return "{$part1}-{$part2}-{$part3}";
    }
    public function consumed(): Factory {
        return $this->state(function(array $attributes) {
            return [
                'guest_id' => User::factory(),
                'consumed_at' => fake()->dateTimeThisMonth(),
            ];
        });
    }
}
