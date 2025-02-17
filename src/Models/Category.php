<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Bolt\Concerns\HasUpdates;
use LaraZeus\Bolt\Database\Factories\CategoryFactory;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property string $logo
 */
class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $guarded = [];

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }

    /** @return HasMany<Form> */
    public function forms(): HasMany
    {
        return $this->hasMany(config('zeus-bolt.models.Form'));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk(config('zeus-wind.uploads.disk', 'public'))->url($this->logo),
        );
    }
}
