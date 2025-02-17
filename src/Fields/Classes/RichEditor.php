<?php

namespace LaraZeus\Bolt\Fields\Classes;

use LaraZeus\Bolt\Fields\FieldsContract;

class RichEditor extends FieldsContract
{
    public string $renderClass = \Filament\Forms\Components\RichEditor::class;

    public int $sort = 10;

    public function title(): string
    {
        return __('Rich Editor');
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
