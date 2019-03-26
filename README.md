## A simple and model-independent Access Control List manager

### WARNING: this library is currently under construction.

With this library you can check against a role-based permission list to control access to your application.
It is completely model-independent, eg. you can (actually you must) define your own implementation of roles, permission
and group management. 

The library provides 3 contracts (interfaces) to help you contruct your managements classes. You
don't need to implement all the 3 interfaces. If you want to check only the use permissions and dont
want to create roles or groups, you only need to implement the `PermissionsManagerContract`. 

If you want to group the permissions into roles and associate the roles to users, you must implement
the `RolesManagerContract`. And if you want to organize roles (and permissions) into groups, you
must implement the `GroupsManagerContract`.
 
Go to the `/examples` directory to find some sample codes.

In the below snippet we assume that `$roleManager` implements de `RolesManagerContract`.

```php

#Put this on the boostrap of your application
use ACL\ACL;

ACL::setRolesManager($roleManager) 
ACL::setPermissionsManager($permissionsManager);
ACL::setGroupsManager($groupsManager);

#you should tell the ACL who is the user, you should do this in your authorization
#layer
ACL::setUserId($user_id);

#now you can check if the user has the permission
ACL::hasPermission('documents.delete');

```