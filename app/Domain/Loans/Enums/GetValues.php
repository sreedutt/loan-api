<?php

namespace Domain\Loans\Enums;

trait GetValues
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
