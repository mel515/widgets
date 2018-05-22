<?php

namespace InetStudio\Widgets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use InetStudio\Widgets\Contracts\Models\WidgetModelContract;

class WidgetModel extends Model implements WidgetModelContract
{
    use SoftDeletes;
    use HasJSONColumns;

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
        'directive', 'view', 'params',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'params' => 'array',
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
}
