<?php

namespace LaraZeus\Bolt\Fields\Classes;

use Filament\Forms\Components\Select as FilamentSelect;
use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;
use LaraZeus\Bolt\Models\Collection;

class MultiSelect extends FieldsContract
{
    public $disabled = false;

    public function __construct()
    {
        $this->definition = [
            'type' => '\Filament\Forms\Components\MultiSelect',
            'title' => __('Multi Select Menu'),
            'order' => 3,
        ];
    }

    public static function getOptions()
    {
        return [
            FilamentSelect::make('options.dataSource')->required()->options(Collection::pluck('name', 'id'))->label(__('Data Source'))->columnSpan(2),
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
