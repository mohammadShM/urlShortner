<?php

namespace App\Models;

use App\Exceptions\CodeGenerationException;
use App\Helpers\Math;
use App\Traits\Eloquent\TouchesTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed id
 * @property mixed code
 * @property mixed original_url
 * @method static factory()
 * @method static firstOrNew(array $array)
 */
class Link extends Model
{

    use HasFactory, TouchesTimestamps;

    protected $guarded = ['id'];

    protected $dates = [
        'last_requested', 'last_used'
    ];

    /**
     * @throws CodeGenerationException
     */
    public function getCode(): string
    {
        if ($this->id === null) {
            throw  new CodeGenerationException();
        }
        return Math::to_base($this->id);
    }

    public static function byCode($code)
    {
        return static::where('code', $code);
    }

    public function shortenedUrl(): ?string
    {
        if ($this->code === null) {
            return null;
        }
        /** @noinspection LaravelFunctionsInspection */
        return env('CLIENT_URL') . $this->code;
    }

}
