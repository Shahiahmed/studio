<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'task',
        'solution',
        'result',
        'image',
        'url',
        'tags',
        'is_concept',
        'is_published',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_concept' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (blank($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort')->orderByDesc('id');
    }

    public function imageUrl(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    /**
     * Seeded covers come in two widths (name-1600.webp / name-900.webp).
     */
    public function imageSrcset(): ?string
    {
        if (! $this->image || ! str_ends_with($this->image, '-1600.webp')) {
            return null;
        }

        $small = str_replace('-1600.webp', '-900.webp', $this->image);

        if (! Storage::disk('public')->exists($small)) {
            return null;
        }

        return asset('storage/'.$small).' 900w, '.asset('storage/'.$this->image).' 1600w';
    }
}
