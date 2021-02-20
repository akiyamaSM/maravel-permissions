<?php


namespace Inani\Maravel;

trait HasRole
{
    /**
     * The role related to
     *
     * @return Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The scanner
     *
     * @return RoleManager
     */
    public function roleManager()
    {
        /** @var RoleManager $conan */
        $conan = resolve(RoleManager::class);

        return $conan->scan($this);
    }
}
