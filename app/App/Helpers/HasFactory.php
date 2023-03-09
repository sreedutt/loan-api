<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param callable|array|int|null $count
     * @param callable|array          $state
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    public static function factory($count = null, $state = [])
    {
        $factoryName = static::newFactory() ?: Str::of(get_called_class())
            ->replace('Models', 'Factories')
            ->append('Factory')
            ->value();
        $factory = $factoryName::new();

        return $factory
                    ->count(is_numeric($count) ? $count : null)
                    ->state(is_callable($count) || is_array($count) ? $count : $state);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
    }
}
