<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Sortable;

    
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'email_verified_at',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $sortable = [
        'name',
        'username',
        'email',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public static function getPermissionGroups()
    {
        $permission_groups = Permission::select('group_name')->groupBy('group_name')->get();

        return $permission_groups;
    }

    public static function getPermissionByGroupName(String $group_name)
    {
        $permissions = Permission::select('id', 'name')->where('group_name', $group_name)->get();

        return $permissions;
    }

    public static function roleHasPermission($role, $permissions)
    {
        $hasPermission = true;

        foreach ($permissions as $permission) {
            if(!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
            return $hasPermission;
        }
    }
}
