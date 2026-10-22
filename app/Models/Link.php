<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['link', 'title', 'button_id', 'type_params', 'type', 'custom_icon'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
          if (config('tnscard.disable_random_link_ids') != 'true') {
            $numberOfDigits = config('tnscard.link_id_length') ?? 9;

            $minIdValue = 10**($numberOfDigits - 1);
            $maxIdValue = 10**$numberOfDigits - 1;

            do {
                $randomId = rand($minIdValue, $maxIdValue);
            } while (Link::find($randomId));

            $link->id = $randomId;
          }
        });
    }
}
