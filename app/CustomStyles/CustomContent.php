<?php

namespace App\CustomStyles;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webmagic\Core\Presenter\PresentableTrait;
use Webmagic\Core\Presenter\Presenter;

class CustomContent extends Model
{
    use PresentableTrait;

    /** @var  Presenter class that using for present model */
    protected $presenter = CustomContentPresenter::class;

    protected $table = 'custom_content';

    protected $fillable = [
        'point_image_1',
        'point_text_1',
        'point_image_2',
        'point_text_2',
        'point_image_3',
        'point_text_3',
        'point_image_4',
        'point_text_4',
        'user_id',
        'point_text_header_1',
        'point_text_header_2',
        'point_text_header_3',
        'point_text_header_4'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
