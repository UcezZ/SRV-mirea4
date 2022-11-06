<?php

class Locale
{
    private static $data = null;

    private static function getData()
    {
        if (!isset(Locale::$data)) {
            Locale::$data = json_decode(file_get_contents(__DIR__ . '/locale.json'), true);
        }
        return Locale::$data;
    }

    public static function gatherLocale(?string $locale = null)
    {
        if ($locale) {
            $locale = strtolower($locale);
            if (isset(Locale::getData()[$locale])) {
                return $locale;
            }
        }
        $user = User::getUser();
        return Locale::gatherLocale(isset($user) ? $user->getLocale() : Locale::parseBrowserLocale());
    }

    public static function parseBrowserLocale()
    {
        $browserLocale = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $idx = strlen($browserLocale);
        $locale = '';
        foreach (Locale::getSupportedLocales() as $key => $value) {
            $curidx = strrpos($browserLocale, $key);
            if ($curidx < $idx) {
                $idx = $curidx;
                $locale = $key;
            }
        }
        return strlen($locale) ? $locale : 'en';
    }

    public static function getValue(string $alias)
    {
        $alias = strtolower($alias);
        return Locale::getData()[Locale::gatherLocale()]['data'][$alias] ??
            Locale::getData()['en']['data'][$alias] ??
            $alias;
    }

    public static function getSupportedLocales()
    {
        $locales = [];
        foreach (Locale::getData() as $key => $locale) {
            $locales[$key] = $locale['caption'];
        }
        return $locales;
    }
}
