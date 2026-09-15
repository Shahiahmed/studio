<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public const STATUSES = [
        'new' => 'Новая',
        'in_progress' => 'В работе',
        'won' => 'Договор',
        'lost' => 'Отказ',
    ];

    protected $fillable = [
        'name',
        'contact',
        'project_type',
        'message',
        'status',
        'note',
        'source',
        'ip',
    ];

    public function projectTypeLabel(): ?string
    {
        return config("studio.project_types.{$this->project_type}");
    }
}
