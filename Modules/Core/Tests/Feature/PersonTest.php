<?php
namespace Modules\core\Tests\Feature;

use Modules\core\Models\Person;
use Tests\TestCase;

class PersonTest extends TestCase
{
    protected function generateData()
    {
        return [
            'dni' => $this->faker->sentence,
            'first_name' => $this->faker->sentence,
            'last_name' => $this->faker->sentence,
            'address' => $this->faker->sentence,
            'birthdate' => $this->faker->sentence,
            'civil_status' => $this->faker->sentence,
            'room_telephone' => $this->faker->sentence,
            'mobile_phone' => $this->faker->sentence,
            'email' => $this->faker->sentence,
            'nationality' => $this->faker->sentence,
            'gender' => $this->faker->sentence,
            'height' => $this->faker->sentence,
            'weight' => $this->faker->sentence,
            'shirt_size' => $this->faker->sentence,
            'size_pants' => $this->faker->sentence,
            'shoe_size' => $this->faker->sentence,
            'profession' => $this->faker->sentence,
            'academic_level' => $this->faker->sentence,
            'country' => $this->faker->sentence,
            'state' => $this->faker->sentence,
            'municipality' => $this->faker->sentence,
            'parish' => $this->faker->sentence,
            'military_component' => $this->faker->sentence,
            'military_rank' => $this->faker->sentence,
            'number_children' => $this->faker->sentence,
            'spouse_works' => $this->faker->sentence,
            'observation' => $this->faker->sentence,
            'photos' => $this->faker->sentence,
            'turn' => $this->faker->sentence,
            'schedule' => $this->faker->sentence,
            'blood_type' => $this->faker->sentence,
            'file_number' => $this->faker->sentence,
            'management' => $this->faker->sentence,
            'organization_id' => $this->faker->sentence,
                    ];
    }

    /** @test  */
    public function test_can_create_person()
    {
        $data = $this->generateData();

        $this->person(route('person.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /** @test  */
    public function test_can_update_person()
    {
        $person = factory(Person::class)->create();

        $data = $this->generateData();

        $this->put(route('person.update', $person->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    /** @test  */
    public function test_can_show_person()
    {
        $person = factory(Person::class)->create();

        $this->get(route('person.show', $person->id))
            ->assertStatus(200);
    }

    /** @test  */
    public function test_can_delete_person()
    {
        $person = factory(Person::class)->create();

        $this->delete(route('person.delete', $person->id))
            ->assertStatus(204);
    }

    /** @test  */
    public function test_can_list_persons()
    {
        $persons = factory(Person::class, 2)->create()->map(function ($person) {
            return $person->only(['dni', 'first_name', 'last_name', 'address', 'birthdate', 'civil_status', 'room_telephone', 'mobile_phone', 'email', 'nationality', 'gender', 'height', 'weight', 'shirt_size', 'size_pants', 'shoe_size', 'profession', 'academic_level', 'country', 'state', 'municipality', 'parish', 'military_component', 'military_rank', 'number_children', 'spouse_works', 'observation', 'photos', 'turn', 'schedule', 'blood_type', 'file_number', 'management', 'organization_id']);
        });

        $this->get(route('person'))
            ->assertStatus(200)
            ->assertJson($persons->toArray())
            ->assertJsonStructure([
                '*' => ['dni', 'first_name', 'last_name', 'address', 'birthdate', 'civil_status', 'room_telephone', 'mobile_phone', 'email', 'nationality', 'gender', 'height', 'weight', 'shirt_size', 'size_pants', 'shoe_size', 'profession', 'academic_level', 'country', 'state', 'municipality', 'parish', 'military_component', 'military_rank', 'number_children', 'spouse_works', 'observation', 'photos', 'turn', 'schedule', 'blood_type', 'file_number', 'management', 'organization_id'],
            ]);
    }
}
