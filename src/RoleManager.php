<?php


namespace Inani\Maravel;


class RoleManager
{
    /**
     * @var HasRole
     */
    protected $hero;

    /**
     * Scan the user
     *
     * @param HasRole $hero
     * @return RoleManager
     */
    public function scan($hero)
    {
        $this->hero = $hero;

        return $this;
    }

    /**
     * check if can do
     *
     * @param $super_powers_id
     * @return mixed
     */
    public function owns($super_powers_id)
    {
        $super_powers_id = is_array($super_powers_id) ? $super_powers_id : [$super_powers_id];

        return $this->hero->role()->whereHas('abilities', function ($query) use($super_powers_id) {
            return $query->whereIn('id', $super_powers_id);
        })->exists();
    }


    /**
     * Owns one of these powers
     *
     * @param array $super_powers
     * @return mixed
     */
    public function ownsOneOf(array $super_powers)
    {
        return $this->owns($super_powers);
    }

    /**
     * Give a user the role
     *
     * @param Role $role
     * @return $this
     */
    public function blessWith(Role $role)
    {
        $this->hero->role()->associate($role);
        $this->hero->save();
        return $this;
    }

    /**
     * Make it human again
     *
     * @return $this
     */
    public function humanize()
    {
        $this->hero->role()->dissociate();
        $this->hero->save();
        return $this;
    }
}
