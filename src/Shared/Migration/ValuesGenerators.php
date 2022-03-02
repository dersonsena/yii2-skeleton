<?php

declare(strict_types=1);

namespace App\Shared\Migration;

use DateTime;
use Ramsey\Uuid\Uuid;

trait ValuesGenerators
{
    /**
     * Generate the binary ID from a uuid string
     * @param string $uuid
     * @return string
     */
    public function generateId(string $uuid)
    {
        return Uuid::fromString($uuid)->getBytes();
    }

    /**
     * Generate the timestamp from current date and time
     * @return string
     * @throws \Exception
     */
    public function nowValue(): string
    {
        return (new DateTime())->format('Y-m-d H:i:s');
    }
}
