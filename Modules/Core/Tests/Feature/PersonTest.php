<?php
namespace Modules\core\Tests\Feature;

use Modules\core\Models\Person;
use Tests\TestCase;

class PersonTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'dni' => $faker->numberBetween(5000000, 30000000),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'address' => $faker->address,
            'birthdate' => $faker->date('Y-m-d', '-18 years') ,
            'civil_status' => $faker->randomElement(['C', 'S', 'D', 'V']),
            'room_telephone' => $faker->phoneNumber,
            'mobile_phone' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'nationality' => $faker->randomElement(['C', 'E']),
            'gender' => $faker->randomElement(['M', 'F']),
            'height' => $faker->numberBetween(150, 210),
            'weight' => $faker->numberBetween(48, 130),
            'shirt_size' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XL']),
            'size_pants' => $faker->numberBetween(30, 54),
            'shoe_size' => $faker->numberBetween(28, 54),
            'profession' => $faker->word,
            'academic_level' => $faker->word,
            'country' => $faker->country,
            'state' => $faker->state,
            'municipality' => $faker->city,
            'parish' => $faker->word,
            'military_component' => $faker->word,
            'military_rank' => $faker->word,
            'number_children' => $faker->numberBetween(0, 5),
            'spouse_works' => $faker->word,
            'observation' => $faker->text(250),
            'photos' => $faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'turn' => $faker->word,
            'schedule' => $faker->word,
            'blood_type' => $faker->text(5),
            'file_number' => $faker->word,
            'management' => $faker->word,
            'organization_id' => $faker->word,
        ];
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_create_person()
    {
        $data = $this->generateData();

        $this->post(route('person.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_update_person()
    {
        $person = factory(Person::class)->create();

        $data = $this->generateData();

        $this->put(route('person.update', $person->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_show_person()
    {
        $person = factory(Person::class)->create();

        $this->get(route('person.show', $person->id))
            ->assertStatus(200);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_delete_person()
    {
        $person = factory(Person::class)->create();

        $this->delete(route('person.destroy', $person->id))
            ->assertStatus(204);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_list_persons()
    {
        $persons = factory(Person::class, 2)->create()->map(function ($person) {
            return $person->only(['dni', 'first_name', 'last_name']);
        });

        $this->get(route('person.index'))
            ->assertStatus(200)
            ->assertJson($persons->toArray())
            ->assertJsonStructure([
                '*' => ['dni', 'first_name', 'last_name'],
            ]);
    }
}
