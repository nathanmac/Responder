<?php namespace Nathanmac\Utilities\Responder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Responder Facade, supporting Laravel implementations.
 *
 * @package    Nathanmac\Utilities\Responder\Facades
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class Responder extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Responder'; }

}
