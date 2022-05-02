<?php


namespace App\Enum;

use App\Enum\Base\AbstractEnum;

class RoleEnum extends AbstractEnum
{
    const ROLE_SUPER_ADMIN = 'Super Admin';
    const ROLE_CLIENT  = 'Client';
    const ROLE_MEMBER  = 'Member';
}
