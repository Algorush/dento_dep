<?php

namespace Webmagic\Dashboard\Api\Http\Middleware;

use App\Services\GlobalMerchantSettings;
use Closure;
use Webmagic\Dashboard\Services\DashboardSettingsManager;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = (new DashboardSettingsManager)->getLocale();

        App::setLocale($lang);

        return $next($request);
    }
}
