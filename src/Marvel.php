<?php

namespace Inani\Maravel;

use Illuminate\Database\Eloquent\Model;

class Marvel extends Model
{
    protected $guarded = [];

    /**
     * The abilities
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities()
    {
        return $this->belongsToMany(Ability::class);
    }

    /**
     * Keep only those abilities
     *
     * @param array $abilities
     * @return Marvel
     */
    public function keep(array $abilities)
    {
        $this->abilities()->sync($abilities);

        return $this;
    }

    /**
     * Take of the ability from the marvel
     *
     * @param $ability Ability|integer
     * @return $this
     */
    public function takeOff($ability)
    {
        $ability = $ability instanceof Ability ? $ability->id : $ability;

        $this->abilities()->detach($ability);

        return $this;
    }

    /**
     * Grant the marvel an ability
     *
     * @param $ability Ability|integer
     * @return $this
     */
    public function grant($ability)
    {
        $ability = $ability instanceof Ability ? $ability->id : $ability;

        $this->abilities()->attach($ability);

        return $this;
    }
}
