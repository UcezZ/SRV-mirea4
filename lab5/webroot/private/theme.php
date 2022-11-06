<?php

class Theme
{
    private static $data = null;

    private static function getData()
    {
        if (!isset(Theme::$data)) {
            Theme::$data = json_decode(file_get_contents(__DIR__ . '/theme.json'), true);
        }
        return Theme::$data;
    }

    public static function gatherTheme(?string $theme = null)
    {
        if ($theme) {
            $theme = strtolower($theme);
            if (isset(Theme::getData()[$theme])) {
                return $theme;
            } else {
                return 'dark';
            }
        }
        $user = User::getUser();
        return Theme::gatherTheme($user ? $user->getTheme() : 'dark');
    }

    public static function getLink()
    {
        return Theme::getData()[Theme::gatherTheme()]['css'];
    }

    public static function getSupportedThemes()
    {
        $themes = [];
        foreach (Theme::getData() as $key => $theme) {
            $themes[$key] = Locale::getValue('theme.' . $key);
        }
        return $themes;
    }
}
