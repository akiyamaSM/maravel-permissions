<?php

namespace Inani\Maravel;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $guarded = [];

    protected $table = 'maravel_abilities';
    /**
     * Roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
