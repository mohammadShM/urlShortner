<?php

namespace App\Models;

use App\Exceptions\CodeGenerationException;
use App\Helpers\Math;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed id
 * @method static factory()
 */
class Link extends Model
{

    use HasFactory;

    protected $guarded = ['id'];

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
