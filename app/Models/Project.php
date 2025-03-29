<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int id
 * @property string name
 * @property string description
 */
class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    use HasFactory;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
