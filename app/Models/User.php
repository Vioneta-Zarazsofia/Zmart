<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static public function getSingle($id)
    {
        return User::find($id);

    }
    // static public function getAdmin()
    // {
    //     return User::where('is_admin', 1)->get();
    // }
    static public function getAdmin()
    {
        return User::select('users.*')
        ->where('is_admin', '=', 1)
        ->where('is_delete', '=', 0)
        ->orderBy('id', 'desc')
        ->get();
    }

    static public function getCustomer()
    {
        $return =  User::select('users.*');
        if (request()->filled('id')) {
            $return = $return->where('id', request()->get('id'));
        }
        if (request()->filled('name')) {
            $return = $return->where('name', 'like', '%' . request()->get('name') . '%');
        }
        if (request()->filled('email')) {
            $return = $return->where('email', 'like', '%' . request()->get('email') . '%');
        }
        if (request()->filled('from_date')) {
            $return = $return->whereDate('created_at', '>=', request()->get('from_date'));
        }
        if (request()->filled('to_date')) {
            $return = $return->whereDate('created_at', '<=', request()->get('to_date'));
        }
        $return = $return->where('is_admin', '=', 0)
        ->where('is_delete', '=', 0)
        ->orderBy('id', 'desc')
        ->paginate(30);
        return $return;
    }

    static public function getAdminById($id)
    {
        return User::select('users.*')
        ->where('is_admin', '=', 1)
        ->where('is_delete', '=', 0)
        ->orderBy('id', 'desc')
        ->get();
    }
    static public function checkEmail($email)
    {
        return User::select('users.*')
        ->where('email', '=', $email)
        ->first();
    }

    static public function getTotalCustomer()
    {
        return self::select('id')
        ->where('is_admin', '=', 0)
        ->where('is_delete', '=', 0)
        ->count();
    }
     static public function getTotalTodayCustomer()
    {
        return self::select('id')
        ->where('is_admin', '=', 0)
        ->where('is_delete', '=', 0)
        ->whereDate('created_at', '=', date('Y-m-d'))
        ->count();
    }
    static public function getTotalCustomerMonth($start_date, $end_date)
    {
        return self::select('id')
        ->where('is_admin', '=', 0)
        ->where('is_delete', '=', 0)
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->count();
    }
}