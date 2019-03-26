<?php

namespace ACL;

use ACL\contracts\GroupContract;
use ACL\contracts\GroupsManagerContract;
use ACL\contracts\PermissionContract;
use ACL\contracts\PermissionsManagerContract;
use ACL\contracts\RoleContract;
use ACL\contracts\RolesManagerContract;
use ACL\contracts\UserContract;
use Illuminate\Support\Str;

abstract class ACL
{

    private static $user_id = NULL;

    private static $roles_manager = NULL;
    private static $permissions_manager = NULL;
    private static $groups_manager = NULL;

    /**
     * Defines the user to be evaluated by the ACL. Normally you should set this
     * to the user id of the logged in user.
     * @param $user_id
     */
    public static function setUserId($user_id)
    {
        self::$user_id = $user_id;
    }

    /**
     * Retrieves the user being used by default by the evaulations of the ACL.
     * Returns NULL if it doenst exists.
     * @return int|null
     */
    public static function getUserId()
    {
        return self::$user_id;
    }

    public static function setRolesManager(RolesManagerContract $manager)
    {
        self::$roles_manager = $manager;
    }

    public static function setPermissionsManager(PermissionsManagerContract $manager)
    {
        self::$permissions_manager = $manager;
    }

    public static function setGroupsManager(GroupsManagerContract $manager)
    {
        self::$groups_manager = $manager;
    }

    public static function hasPermission($slug, UserContract $user = NULL)
    {

        if (is_null($user) && is_null(self::$user_id))
            return false;

        if (is_null(self::$permissions_manager))
            return false;

        $user_id = (is_null($user)) ? self::$user_id : $user->getId();


        //Check if the user has the permission directly associated to him
        if (self::$permissions_manager->userHasPermission($user_id, $slug))
            return true;

        //Check if one of his ROLES has the permission associated to
        if (self::$roles_manager->userRolesHasPermission($user_id, $slug))
            return true;

        //Check if one of his GROUPS has the permission associated to
        if (self::$groups_manager->userGroupsHasPermission($user_id, $slug))
            return true;

        //Here we assume that the user doesnt have the informed permission
        return false;
    }

    public static function hasRole($slug, UserContract $user = NULL)
    {

        if (is_null($user) && is_null(self::$user_id))
            return false;

        if (is_null(self::$roles_manager))
            return false;

        $user_id = (is_null($user)) ? self::$user_id : $user->getId();

        return self::$roles_manager->userHasRole($user_id, $slug);
    }

    public static function hasGroup($slug, UserContract $user = NULL)
    {

        if (is_null($user) && is_null(self::$user_id))
            return false;

        if (is_null(self::$groups_manager))
            return false;

        $user_id = (is_null($user)) ? self::$user_id : $user->getId();

        return self::$groups_manager->userHasGroup($user_id, $slug);
    }

    public static function createRole($name, $slug, $description)
    {
        if (is_null(self::$roles_manager))
            throw new \Exception("You didnt pass a object of a class that implements the RolesManagerContract to the ACL");

        return self::$roles_manager->createRole($name, $slug, $description);
    }

    public static function createPermission($name, $slug, $description)
    {
    }

    public static function createGroup($name, $slug, $description)
    {
    }

    public static function getUserPermissions(UserContract $user = NULL)
    {
        if (!$user)
            $user_id = self::$user_id;
        else
            $user_id = $user->getId();

        return self::getUserPermissionsByUserId($user_id);
    }

    public static function getUserPermissionsByUserId($user_id)
    {
        $permissions = (array)self::$permissions_manager->getUserPermissions($user_id);
        foreach ($permissions as $val)
            if (!($val instanceof PermissionContract))
                throw new \Exception("PermissionManager::getUserPermissions must return an Array with elements that implements the PermissionContract");

        return $permissions;
    }

    public static function getUserRoles(UserContract $user = NULL)
    {
        if (!$user)
            $user_id = self::$user_id;
        else
            $user_id = $user->getId();

        return self::getUserRolesByUserId($user_id);
    }

    public static function getUserRolesByUserId($user_id)
    {
        $roles = (array)self::$roles_manager->getUserRoles($user_id);
        foreach ($roles as $val)
            if (!($val instanceof RoleContract))
                throw new \Exception("RoleManager::getUserRoles must return an Array with elements that implements the RoleContract");

        return $roles;
    }

    public static function getUserGroups(UserContract $user = NULL)
    {
        if (!$user)
            $user_id = self::$user_id;
        else
            $user_id = $user->getId();

        return self::getUserGroupsByUserId($user_id);
    }

    public static function getUserGroupsByUserId($user_id)
    {
        $groups = (array)self::$groups_manager->getUserGroups($user_id);
        foreach ($groups as $val)
            if (!($val instanceof GroupContract))
                throw new \Exception("GroupManager::getUserGroups must return an Array with elements that implements the GroupContract");

        return $groups;
    }

    public static function addPermissionToRole(PermissionContract $permission, RoleContract $role)
    {
    }

    public static function addPermissionToUser(PermissionContract $permission, UserContract $user)
    {
    }

    public static function addPermissionToGroup(PermissionContract $permission, GroupContract $group)
    {
    }

    public static function addRoleToUser(RoleContract $role, UserContract $user)
    {
    }

    public static function addRoleToGroup(RoleContract $role, GroupContract $group)
    {
    }

}