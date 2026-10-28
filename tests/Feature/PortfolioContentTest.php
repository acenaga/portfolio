<?php

use App\Models\Project;
use App\Services\PortfolioContent;
use Illuminate\Support\Facades\Cache;

test('home page renders seeded content from the database', function () {
    $this->seed();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Mentoría Bot', false);
    $response->assertSee('Programación I', false);
    $response->assertSee('PHP no está muerto (y aquí lo demuestro)', false);
    $response->assertSee('@acenaga.dev', false);
    $response->assertSee('AÑOS DE EXPERIENCIA', false);
    $response->assertSee('142K', false);
});

test('portfolio content collections are cached after first read', function () {
    $this->seed();

    PortfolioContent::projects();

    expect(Cache::has('portfolio.projects'))->toBeTrue();

    $before = PortfolioContent::projects();

    PortfolioContent::flush();

    expect(Cache::has('portfolio.projects'))->toBeFalse()
        ->and(PortfolioContent::projects())->not->toBe($before);
});

test('saving content from the panel invalidates the cache', function () {
    $this->seed();

    PortfolioContent::projects();

    expect(Cache::has('portfolio.projects'))->toBeTrue();

    $project = Project::query()->firstOrFail();
    $project->update(['name' => 'Proyecto Renombrado']);

    expect(Cache::has('portfolio.projects'))->toBeFalse();
});
