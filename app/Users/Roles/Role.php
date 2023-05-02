<?php

namespace App\Users\Roles;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
