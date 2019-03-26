<?php

namespace ACL\contracts;

interface RolesManagerContract{

    function userRolesHasPermission($user_id, $permission_slug);
    function userHasRole($user_id, $role_slug);
    function createRole($name, $slug, $description);
}