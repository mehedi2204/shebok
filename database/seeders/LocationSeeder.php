<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $bd = Location::create(['name' => 'Bangladesh', 'type' => 'country']);

        $divisions = [
            'Dhaka' => ['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail'],
            'Chattogram' => ['Chattogram', 'Cox\'s Bazar', 'Cumilla', 'Feni'],
            'Rajshahi' => ['Rajshahi', 'Bogra', 'Pabna', 'Naogaon'],
            'Khulna' => ['Khulna', 'Jashore', 'Kushtia', 'Satkhira'],
            'Sylhet' => ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj'],
            'Barishal' => ['Barishal', 'Bhola', 'Pirojpur', 'Patuakhali'],
            'Rangpur' => ['Rangpur', 'Dinajpur', 'Kurigram', 'Gaibandha'],
            'Mymensingh' => ['Mymensingh', 'Jamalpur', 'Netrokona', 'Sherpur'],
        ];

        foreach ($divisions as $divName => $districts) {
            $div = Location::create([
                'name' => $divName,
                'type' => 'division',
                'parent_id' => $bd->id
            ]);

            foreach ($districts as $distName) {
                Location::create([
                    'name' => $distName,
                    'type' => 'city', // Using 'city' type for districts as per migration enum
                    'parent_id' => $div->id
                ]);
            }
        }
    }
}
