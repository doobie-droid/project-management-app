<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 *
 * @property int id
 * @property string name
 */
class Task extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'name',
        'project_id'
    ];

    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->ordered();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
