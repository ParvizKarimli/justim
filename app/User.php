<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hootlex\Friendships\Traits\Friendable;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isOnline()
    {
        if(
            \DB::table('sessions')
            ->select('user_id')
            ->where('last_activity', '>=', time() - 60)
            ->where('user_id', '=', $this->id)
            ->first()
        )
        {
            return true;
        }

        return false;
    }
}
