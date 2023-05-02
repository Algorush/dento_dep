<?php

namespace App\Users;

use App\CustomStyles\CustomContent;
use App\CustomStyles\CustomStyling;
use App\Deal\Deal;
use App\Notifications\ResetPassword;
use App\Users\Roles\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webmagic\Core\Presenter\PresentableTrait;
use Webmagic\Core\Presenter\Presenter;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable, PresentableTrait, SoftDeletes;

    /** @var  Presenter class that using for present model */
    protected $presenter = UserPresenter::class;

    /**
     * Control relation for soft delete and restore entities
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->isSeller()){
                $user->casesBySeller()->delete();
                $user->clients()->delete();
            }
            if ($user->isClient()){
                $user->cases()->delete();
            }
        });

        static::restoring(function($user) {
            if ($user->isSeller()) {
                $user->clients()->withTrashed()->restore();
                $user->casesBySeller()->withTrashed()->restore();
            }
            if ($user->isClient()) {
                $user->cases()->withTrashed()->restore();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_name',
        'logo',
        'logo_width',
        'logo_height',
        'role_id',
        'seller_id',
        'custom_css',
        'pdf',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role_id'
    ];

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        if(!is_null($password)){
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Check one role
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return null !== $this->role()->where('name', $role)->first();
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * @return bool
     */
    public function isSeller(): bool
    {
        return $this->hasRole('Seller');
    }

    /**
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->hasRole('Client');
    }

    /**
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return HasOne
     */
    public function customContent()
    {
        return $this->hasOne(CustomContent::class);
    }

    /**
     * @return HasOne
     */
    public function customStyling()
    {
        return $this->hasOne(CustomStyling::class);
    }

    /**
     * @return HasMany
     */
    public function cases()
    {
        return $this->hasMany(Deal::class, 'client_id');
    }

    /**
     * @return HasMany
     */
    public function casesBySeller()
    {
        return $this->hasMany(Deal::class, 'seller_id');
    }

    /**
     * @return belongsTo
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * @return belongsTo
     */
    public function sellerWithTrashed()
    {
        return $this->belongsTo(User::class, 'seller_id')->withTrashed();
    }

    /**
     * @return hasMany
     */
    public function clients()
    {
        return $this->hasMany(User::class, 'seller_id');
    }

    /**
     * Find cases that need shown notification
     *
     * @param bool $for_seller
     * @return Collection
     */
    public function casesWithNotifications(bool $for_seller = false)
    {
        if ($for_seller){
            $cases = $this->casesBySeller();
        } else {
            $cases = $this->cases();
        }

       return $cases->where('need_shown_notification', true)
           ->where('soon_expiration', true)->get();
    }
}
