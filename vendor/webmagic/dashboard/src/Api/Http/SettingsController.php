<?php


namespace Webmagic\Dashboard\Api\Http;

use Illuminate\Http\Request;
use Webmagic\Dashboard\Services\DashboardSettingsManager;

/**
 * Class SettingsController
 * @package Webmagic\Dashboard\Api\Http
 */
class SettingsController
{
    /**
     * @param Request $request
     * @param DashboardSettingsManager $dashboardSettingsManager
     */
    public function setLocale(Request $request, DashboardSettingsManager $dashboardSettingsManager)
    {
        $lang = $request->post('lang');
        if (collect(config('webmagic.dashboard.dashboard.header_navigation_options.available_locales'))->contains('code', $lang)) {
            $dashboardSettingsManager->setLocale($lang);
        }
    }
}