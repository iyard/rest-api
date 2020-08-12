<?php

namespace Tests\Feature\Http\Controllers;

    use App\Models\User;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testShow()
    {
        $user = factory(User::class)->create();

        $response = $this->get(route('users.show', $user));

        $response->assertOk()
            ->assertSee($user->name);
    }
}
