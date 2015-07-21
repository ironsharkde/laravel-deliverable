<?php
/**
 * Created by PhpStorm.
 * User: antonpauli
 * Date: 20/07/15
 * Time: 15:04
 */

namespace IronShark\Deliverable;

use Illuminate\Database\Eloquent\Collection;

trait DeliverableTrait
{
    /**
     * Collection of deliveries
     * @return mixed
     */
    public function deliveries()
    {
        return $this->morphMany('\IronShark\Deliverable\Delivery', 'deliverable');
    }


    /**
     * store delivery tasks
     * @param null $recipients
     * @param int $priority
     * @throws \Exception
     */
    public function deliver($recipients = null, $priority = 0){

        // get array of ids
        $recipientIds = DeliverableTrait::getMultipleUserIds($recipients);
        if($recipientIds === null)
            throw new \Exception('Invalid recipient format');

        // prepare data for bulk insert
        $deliveries = [];
        foreach($recipientIds as $userId){
            $deliveries[] = [
                'deliverable_id' => $this->id,
                'deliverable_type' => get_class($this),
                'user_id' => $userId,
                'priority'=> $priority,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        // cancel previous delivery tasks for current item
        $this->cancelDelivery($recipientIds);
        Delivery::insert($deliveries);
    }


    /**
     * remove all delivery tasks for current item
     * @param null $recipients
     */
    public function cancelDelivery($recipients = null){
        // get array of ids
        $recipientIds = DeliverableTrait::getMultipleUserIds($recipients);

        // remove all delivery tasks
        Delivery::where([
            'deliverable_id' => $this->id,
            'deliverable_type' => get_class($this)
        ])->whereIn('user_id', $recipientIds)->delete();
    }


    /**
     * mark item as delivered or undelivered
     * @param bool|true $delivered
     * @param null $user
     * @throws \Exception
     */
    public function setDelivered($delivered = true, $user = null){

        // get user id
        $userId = DeliverableTrait::getUserId($user);

        if($userId === null)
            throw new \Exception('Invalid user argument');

        $deliveryData = [
            'deliverable_id' => $this->id,
            'deliverable_type' => get_class($this),
            'user_id' => $userId,
        ];

        // set delivered date only if item is undelivered
        if($delivered)
            Delivery::where($deliveryData)->whereNull('delivered_at')->update(['delivered_at' => date('Y-m-d H:i:s')]);
        else
            Delivery::where($deliveryData)->update(['delivered_at' => null]);
    }


    /**
     * check whether current item was delivered
     * @param null $user
     * @return bool
     * @throws \Exception
     */
    public function isDelivered($user = null){
        $userId = DeliverableTrait::getUserId($user);

        if($userId === null)
            throw new \Exception('Invalid user argument');

        return (bool) $this->deliveries()
            ->where('user_id', '=', $user)
            ->whereNotNull('delivered_at')
            ->count();
    }


    /**
     * returns user id from user model or current user
     * @param null $user
     * @return mixed|null
     */
    public static function getUserId($user = null){

        // is already integer id, return
        if(is_integer($user))
            return $user;

        // return current user id, if no user provided
        if($user === null)
            return \Auth::id();

        // return id of user model
        if($user instanceof \Illuminate\Database\Eloquent\Model)
            return $user->id;

        return null;
    }


    /**
     * Return array of user ids
     * @param \App\User|Collection|array|int $user
     * @return array|null
     */
    public static function getMultipleUserIds($user){

        // is already array, return
        if(is_array($user))
            return $user;

        // get ids of user collection
        if($user instanceof \Illuminate\Database\Eloquent\Collection)
            return $user->lists('id')->all();

        // try to get one user id instead of array / collection
        $singleUser = \IronShark\Deliverable\DeliverableTrait::getUserId($user);
        if($singleUser != null)
            return [$singleUser];

        return null;
    }
}