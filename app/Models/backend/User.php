<?php

namespace App\Models\backend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\backend\Role;
use App\Models\backend\Category;
use App\Models\backend\Product;
use App\Models\backend\Post;
use App\Models\backend\Gallery;
use App\Models\backend\Feedback;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'fullname', 'email', 'password', 'phone', 'birthday', 'address', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
        return null !== $this->Roles()->whereIn('name', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->Roles()->where('name', $role)->first();
    }

    public function Roles() {
        return $this->belongsToMany(Role::class);
    }

    public function Category() {
        return $this->hasMany(Category::class,'created_by','id');
    }

    public function Product() {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function Post() {
        return $this->hasMany(Post::class,'category_id','id');
    }

    public function Gallery() {
        return $this->hasMany(Gallery::class,'category_id','id');
    }

    public function Feedback() {
        return $this->hasMany(Feedback::class,'created_by','id');
    }

    public static function searchUser( $name = NULL ,$limit = 15){
        return User::where('status', 1)
                ->where(function($query) use ($name) {
                    $query->where(['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'])
                          ->orWhere(['fullname',"like",'%'.mb_strtolower($name,'UTF-8').'%']);
                })
                ->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listUser( $id = NULL, $role_name = NULL, $roleId = NULL ) {
        if( !empty( $id ) ) {
            if( !empty( $role_name ) ) {
                return User::join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->where([
                        ['roles.name', $role_name],
                        ['id', '<>', $id],
                        ['users.status', 1]
                    ])
                    ->get();
            }elseif( !empty( $roleId ) ) {
                return User::join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->where([
                        ['roles.id', $roleId],
                        ['id', '<>', $id],
                        ['users.status', 1]
                    ])
                    ->get();
            }else {
                return User::where([
                    ['id', '<>', $id],
                    ['status', '1']
                ])->orderBy('id', 'DESC')->get();
            }

        }else {
            if( !empty( $role_name ) ) {
                return User::join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->where([
                        ['roles.name', $role_name],
                        ['users.status', 1]
                    ])
                    ->get();
            }elseif( !empty( $roleId ) ) {
                return User::join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->where([
                        ['roles.id', $roleId],
                        ['users.status', 1]
                    ])
                    ->get();
            }else {
                return User::where("status", 1)->orderBy('id', 'DESC')->get();
            }

        }
    }

    public static function checkExists($id){
        $check = User::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }
}
