<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class DatePicker extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\DatePicker::class;

    public int $sort = 8;

    public function title(): string
    {
        return __('Date Picker');
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
