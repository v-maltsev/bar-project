<?php

declare(strict_types=1);

namespace App\Model\Bar\UseCase\PlayList\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public int $compositionId;
}