<?php 

namespace Mkhodroo\CaseInsensitiveTranslate;

use Illuminate\Translation\Translator;
use Illuminate\Translation\TranslationServiceProvider;

class CaseInsensitiveTranslateProvider extends TranslationServiceProvider
{
    public function register()
    {
        $this->registerLoader();
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $trans = new ExtendedTranslator($loader, $locale);
            $trans->setFallback($app['config']['app.fallback_locale']);
            return $trans;
        });
    }
}

class ExtendedTranslator extends Translator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $key = mb_strtolower($key);
        return parent::get($key, $replace, $locale, $fallback);
    }
}