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
            'dni' => $this->faker->numberBetween(5000000, 30000000),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'birthdate' => $this->faker->date('Y-m-d', '-18 years') ,
            'civil_status' => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'room_telephone' => $this->faker->phoneNumber,
            'mobile_phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'nationality' => $this->faker->randomElement(['C', 'E']),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'height' => $this->faker->numberBetween(150, 210),
            'weight' => $this->faker->numberBetween(48, 130),
            'shirt_size' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XL']),
            'size_pants' => $this->faker->numberBetween(30, 54),
            'shoe_size' => $this->faker->numberBetween(28, 54),
            'profession' => $this->faker->word,
            'academic_level' => $this->faker->word,
            'country' => $this->faker->country,
            'state' => $this->faker->state,
            'municipality' => $this->faker->city,
            'parish' => $this->faker->word,
            'military_component' => $this->faker->word,
            'military_rank' => $this->faker->word,
            'number_children' => $this->faker->numberBetween(0, 5),
            'spouse_works' => $this->faker->word,
            'observation' => $this->faker->text(250),
            'photos' => $this->faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'turn' => $this->faker->word,
            'schedule' => $this->faker->word,
            'blood_type' => $this->faker->text(5),
            'file_number' => $this->faker->word,
            'management' => $this->faker->word,
            'organization_id' => $this->faker->word,
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

        $this->delete(route('person.delete', $person->id))
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

        $this->get(route('person'))
            ->assertStatus(200)
            ->assertJson($persons->toArray())
            ->assertJsonStructure([
                '*' => ['dni', 'first_name', 'last_name'],
            ]);
    }
}
