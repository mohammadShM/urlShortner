<?php

namespace App\Observers;

use App\Exceptions\CodeGenerationException;
use App\Models\Link;

class LinkObserver
{

    /**
     * @throws CodeGenerationException
     */
    public function created(Link $link): void
    {
        $link->update([
            'code'=>$link->getCode(),
        ]);
    }

}
