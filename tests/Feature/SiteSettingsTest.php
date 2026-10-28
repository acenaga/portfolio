<?php

use App\Filament\Pages\ManageSiteSettings;
use App\Models\User;
use App\Settings\SiteSettings;
use Livewire\Livewire;

test('settings migration seeds the defaults', function () {
    $settings = app(SiteSettings::class);

    expect($settings->seo_title)->toContain('Carlos Ferrer')
        ->and($settings->about_p1)->toContain('compila')
        ->and($settings->taglines)->toHaveCount(6);
});

test('site settings drive the seo title and about copy on the home page', function () {
    $settings = app(SiteSettings::class);
    $settings->seo_title = 'Título de prueba';
    $settings->about_p1 = 'Un párrafo distinto para el test.';
    $settings->save();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('<title>Título de prueba</title>', false);
    $response->assertSee('Un párrafo distinto para el test.', false);
});

test('admin can save the settings page', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->assertFormExists()
        ->fillForm(['seo_title' => 'Título guardado desde el panel'])
        ->call('save')
        ->assertNotified();

    expect(app(SiteSettings::class)->seo_title)->toBe('Título guardado desde el panel');
});
