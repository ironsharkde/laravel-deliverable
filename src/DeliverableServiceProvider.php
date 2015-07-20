<?php
/**
 * Created by PhpStorm.
 * User: antonpauli
 * Date: 20/07/15
 * Time: 14:23
 */

namespace IronShark\Deliverable;

use Illuminate\Support\ServiceProvider;

class DeliverableServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot() {
        $this->publishes([
            __DIR__.'/../migrations/2015_07_20_122949_create_deliverable_table.php' => database_path('migrations/2015_07_20_122949_create_deliverable_table.php'),
        ]);
    }

    public function register() {}

    public function when() {
        return array('artisan.start');
    }
}