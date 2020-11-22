<?php

namespace Blashbrook\Papi\Tests\Feature;
use Orchestra\Testbench\TestCase;

use App\Http\Livewire\PatronRegistrationCreate;
use http\Client\Request;
//use Tests\TestCase;
use Livewire\Livewire;
//use App\Mail\ContactFormMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class PatronRegistrationCreateTest extends Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /** @test */
    public function patron_contains_patron_registration_create_livewire_component()
    {
        $this->get('/patron')
            ->assertSeeLivewire('patron-registration-create');
    }

    /** @test */
/*    public function patron_registration_create_form_sends_request()
    {


       $test = Livewire::test(PatronRegistrationCreate::class)
            ->set('NameFirst', 'Test')
            ->set('NameMiddle', 'Test')
            ->set('NameLast', 'Testing')
            ->set('Email', 'someguy@someguy.com')
            ->set('PhoneVoice1', '1234567890')
            ->set('StreetOne', '123 Rodeo Dr')
            ->set('City', 'Owensboro')
            ->set('State', 'KY')
            ->set('PostalCode', '42301')
            ->set('Barcode', '12345678901234')
            ->call('submitForm');
            $this->assertSee('We received your message successfully and will get back to you shortly!');

        //Request::assertSent(function (\Illuminate\Http\Client\Request $request) {
            ddd($test);

    }*/

    /** @test */
    public function patronregistrationcreate_namefirst_field_is_required()
    {
        Livewire::test(PatronRegistrationCreate::class)
            ->set('NameFirst', 'Test')
            ->set('NameMiddle', 'Test')
            ->set('NameLast', 'Testing')
            ->set('Email', 'someguy@someguy.com')
            ->set('PhoneVoice1', '1234567890')
            ->set('StreetOne', '123 Rodeo Dr')
            ->set('City', 'Owensboro')
            ->set('State', 'KY')
            ->set('PostalCode', '42301')
            ->set('Barcode', '12345678901234')
            ->call('submitForm')
            ->assertHasErrors(['NameFirst' => 'required']);
    }

    /** @test */

    /** @test */
    public function patronregistrationcreate_email_field_fails_on_invalid_email()
    {
        Livewire::test(PatronRegistrationCreate::class)
            ->set('NameFirst', 'Test')
            ->set('NameMiddle', 'Test')
            ->set('NameLast', 'Testing')
            ->set('Email', 'someguy@someguy.com')
            ->set('PhoneVoice1', '1234567890')
            ->set('StreetOne', '123 Rodeo Dr')
            ->set('City', 'Owensboro')
            ->set('State', 'KY')
            ->set('PostalCode', '42301')
            ->set('Barcode', '12345678901234')
            ->call('submitForm')
            ->assertHasErrors(['Email' => 'email']);
    }

    /** @test */


    /** @test */
    public function patronregistrationcrate_phonevoice1_field_has_minimum_characters()
    {
        Livewire::test(PatronRegistrationCreate::class)
            ->set('PhoneVoice1', '123456789')
            ->call('submitForm')
            ->assertHasErrors(['PhoneVoice1' => 'digits']);
    }
}
