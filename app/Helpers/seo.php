<?php

if (!function_exists('seo')) {
    function seo(?string $pageKey = null, ?string $locale = null)
    {
        if (!$pageKey) {
            // Auto-detect from route name (best practice)
            $pageKey = request()->route()?->getName() ?? 'home';
        }

        return \App\Models\SeoPage::getForPage($pageKey, $locale);
    }
}
