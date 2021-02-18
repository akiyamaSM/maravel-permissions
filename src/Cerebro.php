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
     * @param $super_power
     * @return mixed
     */
    public function owns($super_power)
    {
        $super_power = is_array($super_power) ? $super_power : [$super_power];

        return $this->hero->marvel()->whereHas('abilities', function ($query) use($super_power) {
            return $query->whereIn('super_power', $super_power);
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
