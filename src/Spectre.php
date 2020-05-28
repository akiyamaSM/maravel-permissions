<?php


namespace Inani\Maravel;


class Spectre
{
    protected $name;

    /**
     * @var Marvel
     */
    protected $marvel;

    private function __construct()
    {
    }

    /**
     * Create a new Marvel
     *
     * @param $name
     * @return Spectre
     */
    public static function create($name)
    {
        $instance = new self();
        $instance->name = $name;

        return $instance;
    }

    /**
     * Create marvel with powers
     *
     * @param array $powers
     * @return Marvel
     * @throws \Exception
     */
    public function havingPower(array  $powers)
    {
        if(empty($this->name)){
            throw new \Exception("Marvel name not provided");
        }

        return $this->create_marvel($this->name, $powers);
    }

    /**
     * Create New marvel
     *
     * @param $name
     * @param $abilities
     * @return Marvel
     */
    protected function create_marvel($name, $abilities)
    {
        $abilities = collect($abilities)->map(function ($ability) {
            $ability = Ability::firstOrCreate([
                'super_power' => $ability
            ]);
            return $ability->id;
        })->toArray();

        /** @var Marvel $marvel */
        $marvel = Marvel::firstOrCreate([
            'name' => $name
        ]);

        $marvel->keep($abilities);

        return $marvel;
    }

    /**
     * Select a marvel
     *
     * @param Marvel $marvel
     * @return Spectre
     */
    public static function of(Marvel $marvel)
    {
        $instance = new self();
        $instance->marvel = $marvel;

        return $instance;
    }

    /**
     * Grant a marvel superpower
     *
     * @param $ability
     * @return Marvel
     * @throws \Exception
     */
    public function grant($ability)
    {
        if(empty($this->marvel)){
            throw new \Exception("Marvel name not provided");
        }

        $ability = Ability::firstOrCreate([
            'super_power' => $ability
        ]);

        return $this->marvel->grant($ability);
    }

    /**
     * Grant a marvel superpower
     *
     * @param $ability
     * @return Marvel
     * @throws \Exception
     */
    public function takeOff($ability)
    {
        if(empty($this->marvel)){
            throw new \Exception("Marvel name not provided");
        }

        $ability = Ability::firstOrCreate([
            'super_power' => $ability
        ]);

        return $this->marvel->takeOff($ability);
    }

    /**
     * Reboot the cerebro
     *
     * @return $this
     */
    public function reboot()
    {
        $this->name = '';
        $this->marvel = null;

        return $this;
    }
}
