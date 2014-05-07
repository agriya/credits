<?php namespace Agriya\Credits\Facades;

use Illuminate\Support\Facades\Facade;

class Credits extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'credits'; }

}