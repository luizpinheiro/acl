<?php

namespace ACL\contracts;

interface UserContract{

    public function getId();
    public function getPermissions();
    public function hasPermission($slug);
    public function getRoles();
    public function getGroups();

    public static function getUserPermissions($user_id);
    public static function userHasPermissions($user_id, $slug);
    public static function getUserRoles($user_id);
    public static function getUserGroups($user_id);
}