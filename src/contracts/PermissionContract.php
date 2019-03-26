<?php

namespace ACL\contracts;

interface PermissionContract{

    public function getId();
    public function getSlug();
    public function getUsers();
    public function getRoles();
    public function getGroups();

}