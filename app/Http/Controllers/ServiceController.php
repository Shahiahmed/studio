<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('services.index', [
            'services' => $this->services(),
        ]);
    }

    public function show(string $slug): View
    {
        $services = $this->services();
        $service = $services->firstWhere('slug', $slug);

        abort_unless($service, 404);

        $projects = Project::published()
            ->when($service['project_categories'], fn ($query, $categories) => $query->whereIn('category', $categories))
            ->limit(3)
            ->get();

        return view('services.show', [
            'service' => $service,
            'plans' => collect(studio('pricing'))->whereIn('type', $service['pricing_types'])->values(),
            // A service without its own cases still shows recent work
            'projects' => $projects->isNotEmpty() ? $projects : Project::published()->limit(3)->get(),
            'others' => $services->where('slug', '!=', $slug)->values(),
        ]);
    }

    private function services(): Collection
    {
        return collect(studio('services'));
    }
}
