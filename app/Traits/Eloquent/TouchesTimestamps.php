<?php

namespace App\Traits\Eloquent;

use Illuminate\Support\Carbon;

trait TouchesTimestamps
{

    /** @noinspection PhpUnused */
    public function touchTimeStamp($column): void
    {
        $this->{$column} = Carbon::now();
        $this->save();
    }

}
