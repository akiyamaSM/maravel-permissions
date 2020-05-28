<?php

namespace Inani\Maravel;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $guarded = [];

    /**
     * Marvels
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function marvels()
    {
        return $this->belongsToMany(Marvel::class);
    }
}
