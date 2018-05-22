<?php

namespace InetStudio\Widgets\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Widgets\Contracts\Events\Back\ModifyWidgetEventContract;

/**
 * Class ModifyWidgetEvent.
 */
class ModifyWidgetEvent implements ModifyWidgetEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyWidgetEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
