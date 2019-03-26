<?php

namespace ACL\contracts;

interface GroupsManagerContract{

    public function userGroupsHasPermission($user_id, $permission_slug);
    public function userIsMemberOfGroup($user_id, $group_slug);

}