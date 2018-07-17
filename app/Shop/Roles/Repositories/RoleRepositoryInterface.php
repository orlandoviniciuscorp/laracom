<?php

namespace App\Shop\Roles\Repositories;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Permissions\Permission;
use App\Shop\Roles\Role;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function createRole(array $data) : Role;

    public function listRoles(string $order = 'id', string $sort = 'desc') : Collection;

    public function findRoleById(int $id);

    public function updateRole(array $data, int $id) : bool;

    public function deleteRoleById(int $id) : bool;

    public function attachToPermission(Permission $permission);

    public function attachToPermissions(... $permissions);

    public function syncPermissions(array $ids);

    public function listPermissions() : Collection;
}