<?php
namespace App\Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Models\Navigation;

class NavigationTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function generateData()
    {
        return [
            'title'    => $this->faker->text(120),
            'subtitle' => $this->faker->text(120),
            'type'     => $this->faker->randomElement(['aside', 'basic', 'collapsable', 'divider', 'group', 'spacer']),
            'tooltip'  => $this->faker->text(120),
            'link'     => $this->faker->text(120),
            'icon'     => $this->faker->text(120),
            'order'    => $this->faker->numberBetween(0, 30),
            'meta'     => $this->faker->text(120),
        ];
    }

    protected function getListElementData()
    {
        return [
            'id',
            'title',
            'subtitle',
            'type',
            'tooltip',
            'link',
            'icon',
            'parent',
            'order',
            'meta',
        ];
    }

    public function test_can_create_navigation()
    {
        $data = $this->generateData();

        $response = $this->postJson(route('api.v1.navigations.store'), $data);
        // $response->dump();
        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_update_navigation()
    {
        $navigation = Navigation::factory()->create();

        $data = $this->generateData();
        $response = $this->putJson(route('api.v1.navigations.update', $navigation->id), $data);
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('navigations', [
            'title' => $data['title'],
        ]);
    }

    public function test_can_fetch_single_navigation()
    {
        $navigation = Navigation::factory()->create();

        $response = $this->getJson(route('api.v1.navigations.show', $navigation->getRouteKey()));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_delete_navigation()
    {
        $navigation = Navigation::factory()->create();

        $response = $this->deleteJson(route('api.v1.navigations.destroy', $navigation->getRouteKey()));
        // $response->dump();
        $response->assertOk();

        $this->assertSoftDeleted($navigation);
    }

    public function test_can_list_navigations()
    {
        Navigation::factory()->times(3)->create();

        $response = $this->getJson(route('api.v1.navigations.index') . '?page=1&per_page=5');
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'self',
                'links',
                'meta',
                'data' => [$this->getListElementData()],
            ]);
    }

    public function test_you_can_get_the_navigation_menu()
    {
        $elements = $this->generate_data_for_you_can_get_the_navigation_menu();
        $response = $this->getJson(route('api.v1.navigations.getMenu'));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJson([
                [
                    'id'       => $elements[0]->id,
                    'title'    => 'Admin',
                    'subtitle' => 'Admin',
                    'type'     => 'group',
                    'icon'     => 'heroicons_outline:home',
                    'order'    => 0,
                    'children' => [
                        [
                            'id'       => $elements[1]->id,
                            'title'    => 'Usuarios',
                            'type'     => 'basic',
                            'icon'     => 'heroicons_outline:clipboard-check',
                            'link'     => '/admin/users',
                            'order'    => 0
                        ],
                        [
                            'id'       => $elements[2]->id,
                            'title'    => 'Perfiles',
                            'type'     => 'basic',
                            'icon'     => 'heroicons_outline:clipboard-check',
                            'link'     => '/admin/roles',
                            'order'    => 1
                        ]
                    ]
                ]
            ]);
    }

    public function generate_data_for_you_can_get_the_navigation_menu()
    {
        $elements = [];
        $elements[] = Navigation::create([
            'title'    => 'Admin',
            'subtitle' => 'Admin',
            'type'     => 'group',
            'order'    => 0,
            'icon'     => 'heroicons_outline:home'
        ]);

        $elements[] = Navigation::create([
            'title'    => 'Usuarios',
            'type'     => 'basic',
            'icon'     => 'heroicons_outline:clipboard-check',
            'link'     => '/admin/users',
            'order'    => 0,
            'parent'   => $elements[0]->id
        ]);

        $elements[] = Navigation::create([
            'title'    => 'Perfiles',
            'type'     => 'basic',
            'icon'     => 'heroicons_outline:clipboard-check',
            'link'     => '/admin/roles',
            'order'    => 1,
            'parent'   => $elements[0]->id
        ]);

        return $elements;
    }
}
