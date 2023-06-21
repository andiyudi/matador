<?php

namespace Database\Factories;

use App\Models\Procurement;
use App\Models\Division;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcurementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Procurement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'periode' => date('Y'),
            'name' => 'Pekerjaan ' . $this->faker->word(),
            'number' => 'PP' . $this->faker->regexify('[0-9]{4}-[0-9]{2}'),
            'estimation_time' => $this->faker->randomElement(['1 month', '2 months', '3 months']),
            'division_id' => $this->faker->randomElement(Division::pluck('id')->toArray()),
            'person_in_charge' => $this->faker->name,
            'status' => '0',
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Procurement $procurement) {
            $vendors = Vendor::inRandomOrder()->limit(4)->pluck('id')->toArray();

            $procurement->vendors()->attach($vendors);
        });
    }
}
