<?php

namespace App\Deal;

use App\Users\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Webmagic\Core\Presenter\PresentableTrait;
use Webmagic\Core\Presenter\Presenter;

class Deal extends Model
{
    use SoftDeletes, PresentableTrait;

    /** @var  Presenter class that using for present model */
    protected $presenter = DealPresenter::class;

    protected $table = 'deals';

    protected $fillable = [
        'name',
        'case_id',
        'client_id',
        'seller_id',
        'soon_expiration',
        'need_shown_notification',
        'pdf',
        'ipr',
        'wear_count',
        'wear_times_of_day',
        'upper_position_x',
        'upper_position_y',
        'upper_rotation_y',
        'lower_position_x',
        'lower_position_y',
        'lower_rotation_y',
        'uniqid'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uniqid = uniqid('');
        });

    }

    /**
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * @return BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * @return mixed
     */
    public function clientWithTrashed()
    {
        return $this->belongsTo(User::class, 'client_id')->withTrashed();
    }

    /**
     * @return HasMany
     */
    public function upperFiles()
    {
        return $this->hasMany(UpperFile::class)->orderBy('position');
    }

    /**
     * @return HasMany
     */
    public function lowerFiles()
    {
        return $this->hasMany(LowerFile::class)->orderBy('position');
    }


    /**
     * Count days before deleting
     *
     * @return mixed
     * @throws Exception
     */
    public function leftDaysBeforeDelete()
    {
        $expirationDate = Carbon::now()->subMonths(24);
        $wasCreated = new Carbon($this->created_at);

        $difference = $expirationDate->diff($wasCreated)->days;

        return $difference;
    }

}
