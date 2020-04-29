<?php


namespace App;


trait HasRole
{
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user');
    }

    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->roles->contains('name' , $role);
        }
        return !! $role->intersect($this->roles)->count();
    }
}
