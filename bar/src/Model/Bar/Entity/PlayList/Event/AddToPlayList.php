<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\PlayList\Event;

use App\Model\Bar\Entity\Composition\Composition;

class AddToPlayList
{
    public Composition $composition;

    public function __construct(Composition $composition)
    {
        $this->composition = $composition;
    }
}