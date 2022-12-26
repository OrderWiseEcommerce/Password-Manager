<?php declare(strict_types=1);

namespace App\Domains\Team\Test\Feature;

use App\Domains\Team\Model\Team as Model;

class Delete extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'team.delete';

    /**
     * @var string
     */
    protected string $action = 'delete';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route(null, $this->rowCreate()->id))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route(null, $this->rowCreate()->id))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->get($this->route(null, $this->rowCreate()->id))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostNotAdminFail(): void
    {
        $this->authUserAdmin(false);

        $this->post($this->route(null, $this->rowCreate()->id))
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testGetFail(): void
    {
        $this->authUserAdmin();

        $this->get($this->route(null, $this->rowCreate()->id))
            ->assertStatus(405);
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->authUserAdmin();

        $this->post($this->route(null, $this->rowCreate()->id))
            ->assertStatus(302);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->authUserAdmin();

        $row = $this->rowCreate();

        $this->get(route('team.index'))
            ->assertSee($row->name);

        $this->followingRedirects()
            ->post($this->route(null, $row->id), $this->action())
            ->assertStatus(200)
            ->assertSee('El equipo ha sido borrado correctamente');

        $this->get(route('team.index'))
            ->assertDontSee($row->name);
    }
}
