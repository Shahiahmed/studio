<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('services.index'), 'priority' => '0.9'],
        ])
            ->merge(collect(config('studio.services'))->map(fn (array $service) => [
                'loc' => route('services.show', $service['slug']),
                'priority' => '0.9',
            ]))
            ->merge(Project::published()->get()->map(fn (Project $project) => [
                'loc' => route('projects.show', $project),
                'lastmod' => $project->updated_at?->toAtomString(),
                'priority' => '0.7',
            ]));

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
}
