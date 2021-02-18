<?php


namespace Inani\Maravel;


class Cerebro
{
    /**
     * @var IsMarvel
     */
    protected $hero;

    /**
     * Scan the user
     *
     * @param IsMarvel $hero
     * @return Cerebro
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

        return $this->hero->marvel()->whereHas('abilities', function ($query) use($super_powers_id) {
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
     * Give a user the marvel
     *
     * @param Marvel $marvel
     * @return $this
     */
    public function blessWith(Marvel $marvel)
    {
        $this->hero->marvel()->associate($marvel);
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
        $this->hero->marvel()->dissociate();
        $this->hero->save();
        return $this;
    }
}
