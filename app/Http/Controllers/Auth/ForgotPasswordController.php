<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Users\UserRepo;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * @param Request $request
     * @param $response
     * @return JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Success']);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @param UserRepo $userRepo
     * @return RedirectResponse|JsonResponse
     * @throws Exception
     */
    public function sendResetLinkEmail(Request $request, UserRepo $userRepo)
    {
        $this->validateEmail($request);

        if(!$user = $userRepo->getAccountByEmail($request->email)){
            return response()->json(['message' => 'The account doesn\'t exist'], 500);
        }


        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
