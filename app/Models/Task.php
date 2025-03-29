<?php

namespace App\Models;

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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
