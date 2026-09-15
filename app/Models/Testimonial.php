<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'author',
        'position',
        'company',
        'project',
        'body',
        'is_placeholder',
        'is_published',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'is_placeholder' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort')->orderByDesc('id');
    }

    public function role(): string
    {
        return collect([$this->position, $this->company])->filter()->implode(', ');
    }
}
