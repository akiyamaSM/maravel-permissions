<?php


namespace Inani\Maravel;


class Spectre
{
    protected $name;

    /**
     * @var Marvel
     */
    protected $marvel;

    protected $description;

    /**
     * Create a new Marvel
     *
     * @param $name
     * @param null $description
     * @return Spectre
     */
    public static function create($name, $description = null)
    {
        $instance = new self();
        $instance->name = $name;
        $instance->description = $description;
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

        return $this->create_marvel($this->name, $powers, $this->description);
    }

    /**
     * Create New marvel
     *
     * @param $name
     * @param $abilities
     * @param $description
     * @return Marvel
     */
    protected function create_marvel($name, $abilities, $description)
    {
        $abilities = collect($abilities)->map(function ($ability) use($description) {
            $entity = isset($ability['entity']) ? $ability['entity'] : null;
            $ability = Ability::firstOrCreate([
                'super_power' => $ability['name'],
                'action' => $ability['action'],
                'entity' => $entity,
                'is_entity' => !is_null($entity),
                'description' => $description
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
     * @param $ability int|array
     * @return Marvel
     * @throws \Exception
     */
    public function grant($ability)
    {
        if(empty($this->marvel)){
            throw new \Exception("Marvel name not provided");
        }
        if(is_array($ability)){
            $entity = isset($ability['entity']) ? $ability['entity'] : null;
            $ability = Ability::create([
                'super_power' => $ability['super_power'],
                'action' => $ability['action'],
                'entity' => $entity,
                'is_entity' => !is_null($entity),
                'description' => $ability['description']
            ]);
        }

        return $this->marvel->grant($ability);
    }

    /**
     * Grant a marvel superpower
     *
     * @param $ability Ability|integer
     * @return Marvel
     * @throws \Exception
     */
    public function takeOff($ability)
    {
        if(empty($this->marvel)){
            throw new \Exception("Marvel name not provided");
        }
        return $this->marvel->takeOff($ability);
    }

    /**
     * Reboot the Cerebro
     *
     * @return $this
     */
    public function reboot()
    {
        $this->name = '';
        $this->marvel = null;
        $this->description = null;

        return $this;
    }
}
