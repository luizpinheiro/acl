<?php

namespace ACL\contracts;

interface GroupContract{

    public function getId();
    public function getSlug();
    public function getUsers();
    public function getRoles();
    public function getPermissions();

}