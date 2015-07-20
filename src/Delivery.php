<?php
/**
 * Created by PhpStorm.
 * User: antonpauli
 * Date: 20/07/15
 * Time: 14:23
 */

namespace IronShark\Deliverable;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Delivery extends Eloquent {

	protected $table = 'deliverable';
	public $timestamps = false;
	protected $fillable = [
		'deliverable_id',
		'deliverable_type',
		'user_id',
		'priority',
		'created_at',
		'delivered_at'
	];

	public function deliverable()
	{
		return $this->morphTo();
	}
}