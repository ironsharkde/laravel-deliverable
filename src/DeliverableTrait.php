<?php
/**
 * Created by PhpStorm.
 * User: antonpauli
 * Date: 20/07/15
 * Time: 15:04
 */

namespace IronShark\Deliverable;


trait DeliverableTrait
{
    /**
     * Collection of deliveries
     * @return mixed
     */
    public function deliveries()
    {
        return $this->morphMany('\IronShark\Deliverable\Delivery', 'Delivery');
    }
}