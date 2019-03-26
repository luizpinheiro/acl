<?php

namespace ACL\contracts;

interface PermissionsManagerContract{


    public function userHasPermission($user_id, $slug);
    public function createPermission($name, $sector, $slug, $description);


}