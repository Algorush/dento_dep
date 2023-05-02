<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException as BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webmagic\Dashboard\NotificationService\NotificationService;

class DashboardNotification
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $showNotification = false;

        if ($user->isSeller()){
            $cases = $user->casesWithNotifications(true);
        }

        if ($user->isClient()){
            $cases = $user->casesWithNotifications();
        }

        if (isset($cases) && $cases->count()){
            $messages = $this->prepareMessagesForNotification($cases);
            $showNotification = true;
        }

        if ($showNotification){
           $this->addGlobalNotification($messages);
        }

        return $next($request);
    }

    /**
     * Push notification to massage bag. It will be displayed in global notification area on the page
     *
     * @param array $messages
     * @throws BindingResolutionException
     */
    protected function addGlobalNotification(array $messages)
    {
        $service = app()->make(NotificationService::class);
        foreach ($messages as $message){
            $service->addMessage('warning', $message);
        }
    }

    /**
     * Prepare array of messages for notification blocks
     *
     * @param Collection $cases
     * @return mixed
     */
    protected function prepareMessagesForNotification(Collection $cases)
    {
        foreach ($cases as $case){
            $daysLeft = $case->leftDaysBeforeDelete();
            $messages[] = "The case <b>#$case->case_id</b> will be deleted in $daysLeft days". "<div class='warning-id' data-id=".$case->id."></div>";
        }

        return $messages;
    }
}
