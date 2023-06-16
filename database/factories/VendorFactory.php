<?php

namespace Database\Factories;

use App\Models\Vendor;
use App\Models\CoreBusiness;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classification;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'area' => $this->faker->city,
            'director' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'capital' => $this->faker->numberBetween(100000000, 1000000000),
            'grade' => $this->faker->randomElement(['0', '1', '2']),
            'is_blacklist' => '0',
            'blacklist_at' => null,
            'activated_at' => null,
            'status' => '0',
            'expired_at' => date('Y') . '-12-31',
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Vendor $vendor) {
            $coreBusinesses = CoreBusiness::inRandomOrder()->limit(3)->pluck('id')->toArray();
            $classifications = Classification::inRandomOrder()->limit(9)->pluck('id')->toArray();

            $vendor->coreBusinesses()->attach($coreBusinesses);
            $vendor->classifications()->attach($classifications);
        });
    }
}
