<?php

declare(strict_types=1);

namespace Devops\Command;

use DateTimeZone;

/**
 * Trait DateHelperTrait
 * Helps Commands display dates and times in the user's timezone and preferred format.
 * Ensure setDateTimeFormat is called in services.yaml as auto-wiring does not work for scalar values.
 */
trait DateHelperTrait
{
    /** Timezone to convert the dates in for display only. */
    private DateTimeZone $dateTimeZone;
    /** Date format for all dates viewed from console. */
    private string $dateTimeFormat;

    private function getDateTimeZone(): DateTimeZone
    {
        return $this->dateTimeZone;
    }

    public function setDateTimeZone(DateTimeZone $dateTimeZone): void
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    private function getDateTimeFormat(): string
    {
        return $this->dateTimeFormat;
    }

    public function setDateTimeFormat(string $dateTimeFormat): void
    {
        $this->dateTimeFormat = $dateTimeFormat;
    }
}
