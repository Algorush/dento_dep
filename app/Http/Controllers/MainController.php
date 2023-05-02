<?php

namespace App\Http\Controllers;

use App\Deal\DealRepo;
use App\Users\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Laracasts\Presenter\Exceptions\PresenterException;

class MainController extends Controller
{
    /**
     * Return page by case hash and prepare custom styles for user if their exist
     *
     * @param string $clientName
     * @param string $params
     * @param DealRepo $dealRepo
     * @param UserService $userService
     * @return Application|Factory|View
     * @throws PresenterException
     * @throws Exception
     */
    public function getCasePage(string $clientName, string $params, DealRepo $dealRepo, UserService $userService)
    {
        $case_uniqid = last(explode('-', $params));

        if (! $deal = $dealRepo->getByUniqid($case_uniqid)) {
            abort(404);
        }

        $styles = $userService->getActualStylesForClient($deal, $deal->client ?? $deal->seller);

        return view('main', compact('styles'));
    }

    /**
     * @param string $params
     * @param DealRepo $dealRepo
     * @return JsonResponse
     * @throws Exception
     */
    public function getFilesForCase(string $params, DealRepo $dealRepo)
    {
        $case_uniqid = last(explode('-', $params));

        if (! $deal = $dealRepo->getByUniqid($case_uniqid)) {
            abort(404);
        }

        foreach ($deal->upperFiles as $file){
            $upperFiles[] = $file->present()->file;
        }
        foreach ($deal->lowerFiles as $file){
            $lowerFiles[] = $file->present()->file;
        }

        return response()->json([
            'upperFiles' => $upperFiles ?? [],
            'lowerFiles' => $lowerFiles ?? [],
            'positions' => [
                'upperFiles' => [
                    'position_x' => $deal->upper_position_x,
                    'position_y' => $deal->upper_position_y,
                    'rotation_y' => $deal->upper_rotation_y,
                ],
                'lowerFiles' => [
                    'position_x' => $deal->lower_position_x,
                    'position_y' => $deal->lower_position_y,
                    'rotation_y' => $deal->lower_rotation_y,
                ],
            ]
        ], 200);
    }

}
