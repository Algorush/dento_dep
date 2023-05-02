<?php

namespace App\Console\Commands;

use App\Deal\DealRepo;
use App\Deal\DealService;
use App\Trash\TrashService;
use Illuminate\Console\Command;

class RemovalHandlingOldItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:removal-handling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old items and send notifications for those, who will be removed soon ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * At first, find all cases that need be removed (created six months ago)
     * and destroy if with all related files
     *
     * At second, find all cases that will be removed after 14 days
     * and set "soon expiration" status for notification their owners in admin panel
     *
     * At third, clean all items that were delete more than two months ago
     *
     * @return mixed
     */
    public function handle(DealRepo $dealRepo, DealService $dealService, TrashService $trashService)
    {
        $deals = $dealRepo->getOldForDeleting();
        if ($deals->count()) {
            foreach ($deals as $deal) {
                $dealService->realDestroy($deal);
            }
        }

        $dealsSoonBeRemoved = $dealRepo->getOldForNotification();
        if ($dealsSoonBeRemoved->count()) {
            foreach ($dealsSoonBeRemoved as $deal) {
                $dealRepo->update($deal->id, [
                    'soon_expiration' => true,
                    'need_shown_notification' => true
                ]);
            }
        }

        $trashService->cleanAllExpiredItems();
    }
}
