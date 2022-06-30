<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 * @coversNothing
 */
class SignUpTest extends DuskTestCase
{
    public function testCreateAccount()
    {
        $name = 'John Doe';
        $email = 'johndoe@test.com';
        $password = 'password';

        User::where('email', $email)->delete();

        $this->browse(function (Browser $browser) use ($name, $email, $password) {
            $browser->visit('/cadastrar')
                ->assertSee('Cadastre-se')
            ;

            $browser->type('name', $name)
                ->type('email', $email)
                ->type('password', $password)
                ->press('Cadastrar')
                ->assertPathIs('/home')
            ;
        });

        User::where('email', $email)->delete();
    }
}
