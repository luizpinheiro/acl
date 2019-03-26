<?php

namespace ACL\contracts;

interface RoleContract{

    public function getId();
    public function getSlug();
    public function getUsers();
    public function getPermissions();
    public function getGroups();

}