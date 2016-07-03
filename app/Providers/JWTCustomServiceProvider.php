<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Http\Parser\Parser;
use Tymon\JWTAuth\Http\Parser\AuthHeaders;
use Tymon\JWTAuth\Http\Parser\Cookies;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class JWTCustomServiceProvider extends LaravelServiceProvider
{

  /**
   * Include the Cookie as the source for the parser
   * By default JWT Auth does not include the cookie
   *
   * @return void
   */
  protected function registerTokenParser()
  {
      $this->app->singleton('tymon.jwt.parser', function ($app) {
          $parser = new Parser(
              $app['request'],
              [new AuthHeaders, new Cookies]
          );

          $app->refresh('request', $parser, 'setRequest');

          return $parser;
      });
  }
}
