<?php

namespace App\Deal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webmagic\Core\Presenter\PresentableTrait;
use Webmagic\Core\Presenter\Presenter;
use Rutorika\Sortable\SortableTrait;

class UpperFile extends Model
{
    use PresentableTrait, SortableTrait;

    /** @var  Presenter class that using for present model */
    protected $presenter = UpperAndLowerFilePresenter::class;

    protected $table = 'deals_upper_files';

    protected $fillable = [
        'deal_id',
        'original_name',
        'file_path',
        'position'
    ];

    /**
     * @return BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }
}
