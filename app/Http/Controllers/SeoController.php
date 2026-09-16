<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $projects = Project::published()->get();

        // Каждая страница попадает в карту на всех языках и ссылается на свои переводы
        $urls = collect(array_keys(studio_locales()))
            ->flatMap(fn (string $locale) => $this->pages($locale, $projects))
            ->map(fn (array $url) => $url + ['alternates' => $this->alternates($url['route'], $url['parameters'])]);

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /livewire',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /** Все публичные страницы одного языка. */
    private function pages(string $locale, Collection $projects): Collection
    {
        return collect([
            ['route' => 'home', 'parameters' => [], 'priority' => '1.0'],
            ['route' => 'services.index', 'parameters' => [], 'priority' => '0.9'],
        ])
            ->merge(collect(config('studio.services'))->map(fn (array $service) => [
                'route' => 'services.show',
                'parameters' => ['slug' => $service['slug']],
                'priority' => '0.9',
            ]))
            ->merge($projects->map(fn (Project $project) => [
                'route' => 'projects.show',
                'parameters' => ['project' => $project->slug],
                'lastmod' => $project->updated_at?->toAtomString(),
                'priority' => '0.7',
            ]))
            ->map(fn (array $page) => $page + ['loc' => locale_route($page['route'], $page['parameters'], $locale)]);
    }

    /** hreflang-ссылки на другие языки той же страницы. */
    private function alternates(string $route, array $parameters): array
    {
        return collect(array_keys(studio_locales()))
            ->mapWithKeys(fn (string $locale) => [$locale => locale_route($route, $parameters, $locale)])
            ->all();
    }
}
