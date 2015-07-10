<?php

namespace App\Http\Middleware;

use Closure;
use File;

class Locale {

  public function handle($request, Closure $next) {
    $url = $request->server("HTTP_HOST");
    $parts = explode('.', $url);
    $locale = $parts[0];
    $locales = $this->getLocales();
    if (in_array($locale, $locales) ){
      app()->setLocale($locale);
    }
    return $next($request);
  }

  private function getLocales() {
    $locales = [];
    foreach (File::directories(app()->langPath()) as $langDirectory) {
      $locales[] = File::name($langDirectory);
    }
    return $locales;
  }
}
