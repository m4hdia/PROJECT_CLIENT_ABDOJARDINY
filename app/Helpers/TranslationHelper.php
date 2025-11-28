<?php

namespace App\Helpers;

class TranslationHelper
{
    /**
     * Get translation or return key if not found
     */
    public static function t($key, $replace = [])
    {
        $locale = app()->getLocale();
        $translations = self::getTranslations();
        
        $keys = explode('.', $key);
        $value = $translations;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $key;
            }
        }
        
        // Replace placeholders
        foreach ($replace as $search => $replacement) {
            $value = str_replace(':' . $search, $replacement, $value);
        }
        
        return is_string($value) ? $value : $key;
    }
    
    /**
     * Get all translations for current locale
     */
    private static function getTranslations()
    {
        $locale = app()->getLocale();
        $file = resource_path("lang/{$locale}/translations.json");
        
        if (file_exists($file)) {
            return json_decode(file_get_contents($file), true);
        }
        
        return [];
    }
    
    /**
     * Check if current locale is RTL
     */
    public static function isRTL()
    {
        return app()->getLocale() === 'ar';
    }
    
    /**
     * Get current locale
     */
    public static function getLocale()
    {
        return app()->getLocale();
    }
}




