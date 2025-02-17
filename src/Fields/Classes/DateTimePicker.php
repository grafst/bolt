<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class DateTimePicker extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\DateTimePicker::class;

    public int $sort = 7;

    public function title(): string
    {
        return __('Date Time Picker');
    }

    public static function getOptions(): array
    {
        return [
            self::required(),
            self::htmlID(),
            self::visibility(),
        ];
    }
}
