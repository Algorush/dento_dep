<?php

namespace App\CustomStyles;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomStyling extends Model
{
    /**
     * @var string
     */
    protected $table = 'custom_styling';

    /**
     * @var string[]
     */
    protected $fillable = [
        'primary_color',
        'header_color',
        'body_color',
        'text_color',
        'user_id',
        'background_color',
        'progressbar_color',
        'progressbar_background_color'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
