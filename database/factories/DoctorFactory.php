<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail(),
            'email_verified_at' =>  $this->faker->time(),
            'password' => bcrypt($this->faker->randomLetter),
            'phone' => $this->faker->phoneNumber(),
            'price' => $this->faker->randomFloat(100000,0,40000),
            'section_id' => rand(1 , 5)
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Doctor $doctor) {
            DB::table("doctor_appointments")->insert([
                'doctor_id' => $doctor->id,
                'appointment_id' => rand(1,7),
            ]);
            DB::table("doctor_appointments")->insert([
                'doctor_id' => $doctor->id,
                'appointment_id' => rand(1,7),
            ]);
        });
    }
}
