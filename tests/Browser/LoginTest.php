<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 * @coversNothing
 */
class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample()
    {
        $email = 'johndoe@test.com';
        $password = 'password';

        User::where('email', $email)->delete();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->browse(function (Browser $browser) use ($email, $password) {
            $browser->visit('/login')
                ->assertSee('Login')
            ;

            $browser->type('email', $email)
                ->type('password', $password)
                ->press('Entrar')
                ->assertPathIs('/home')
            ;
        });

        User::where('email', $email)->delete();
    }
}
