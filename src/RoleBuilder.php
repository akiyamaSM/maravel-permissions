<?php


namespace Inani\Maravel;


class RoleBuilder
{
    protected $name;

    /**
     * @var Role
     */
    protected $role;

    protected $description;

    /**
     * Create a new Marvel
     *
     * @param $name
     * @param null $description
     * @return RoleBuilder
     */
    public static function create($name, $description = null)
    {
        $instance = new self();
        $instance->name = $name;
        $instance->description = $description;
        return $instance;
    }

    /**
     * Create role with powers
     *
     * @param array $powers
     * @return Role
     * @throws \Exception
     */
    public function havingPower(array  $powers)
    {
        if(empty($this->name)){
            throw new \Exception("Marvel name not provided");
        }

        return $this->create_role($this->name, $powers, $this->description);
    }

    /**
     * Create New role
     *
     * @param $name
     * @param $abilities
     * @param $description
     * @return Role
     */
    protected function create_role($name, $ability, $description)
    {
        $entity = isset($ability['entity']) ? $ability['entity'] : null;
        $ability = Ability::firstOrCreate([
            'super_power' => $ability['name'],
            'action' => $ability['action'],
            'entity' => $entity,
            'is_entity' => !is_null($entity),
            'description' => $ability['description']
        ]);

        /** @var Role $role */
        $role = Role::firstOrCreate([
            'name' => $name,
        ], [
            'description' => $description
        ]);

        $role->keep([$ability->id]);

        return $role;
    }

    /**
     * Select a role
     *
     * @param Role $role
     * @return RoleBuilder
     */
    public static function of(Role $role)
    {
        $instance = new self();
        $instance->role = $role;

        return $instance;
    }

    /**
     * Grant a role superpower
     *
     * @param $ability int|array
     * @return Role
     * @throws \Exception
     */
    public function grant($ability)
    {
        if(empty($this->role)){
            throw new \Exception("Marvel name not provided");
        }
        if(is_array($ability)){
            $entity = isset($ability['entity']) ? $ability['entity'] : null;
            $ability = Ability::create([
                'super_power' => $ability['name'],
                'action' => $ability['action'],
                'entity' => $entity,
                'is_entity' => !is_null($entity),
                'description' => $ability['description']
            ]);
        }

        return $this->role->grant($ability);
    }

    /**
     * Grant a role superpower
     *
     * @param $ability Ability|integer
     * @return Role
     * @throws \Exception
     */
    public function takeOff($ability)
    {
        if(empty($this->role)){
            throw new \Exception("Marvel name not provided");
        }
        return $this->role->takeOff($ability);
    }

    /**
     * Reboot the Cerebro
     *
     * @return $this
     */
    public function reboot()
    {
        $this->name = '';
        $this->role = null;
        $this->description = null;

        return $this;
    }
}
