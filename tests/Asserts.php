<?php

declare(strict_types=1);

namespace Tests;

trait Asserts
{
    protected string $uuidPattern = '/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/';
    protected string $isoDatetimePattern = '/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(Z|(\+|-)\d{2}(:?\d{2})?)$/';

    public function assertIsoDateTimeString(string $datetime)
    {
        $message = sprintf("Datetime string '%s' is not a valid ISO Datetime format.", $datetime);
        $this->assertMatchesRegularExpression($this->isoDatetimePattern, $datetime, $message);
    }

    public function assertUuid(string $uuid)
    {
        $message = sprintf("UUID string '%s' is not a valid UUID.", $uuid);
        $this->assertMatchesRegularExpression($this->uuidPattern, $uuid, $message);
    }
}
