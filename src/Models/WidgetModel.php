<?php

namespace InetStudio\Widgets\Models;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;

/**
 * Class WidgetModel.
 */
class WidgetModel extends Model implements WidgetModelContract, HasMedia
{
    use SoftDeletes;
    use HasJSONColumns;
    use \InetStudio\Uploads\Models\Traits\HasImages;

    const ENTITY_TYPE = 'widget';
    const BASE_MATERIAL_TYPE = 'widget';

    /**
     * Конфиг изображений.
     *
     * @var array
     */
    private $images = [
        'config' => 'widgets',
        'model' => '',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'widgets';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'view', 'params', 'additional_info',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'params' => 'array',
        'additional_info' => 'array',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Геттер атрибута material_type.
     *
     * @return string
     */
    public function getMaterialTypeAttribute()
    {
        $materialType = $this->additional_info['material_type'] ?? self::BASE_MATERIAL_TYPE;

        return $materialType;
    }

    /**
     * Отношение "один ко многим" с моделью "ссылок" на материалы.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function widgetables(): HasMany
    {
        $widgetableModel = app()->make('InetStudio\Widgets\Contracts\Models\WidgetableModelContract');

        return $this->hasMany(
            get_class($widgetableModel),
            'widget_model_id'
        );
    }
}
