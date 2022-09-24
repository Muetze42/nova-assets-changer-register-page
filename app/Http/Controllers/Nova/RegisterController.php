<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('nova.guest:'.config('nova.guard'))->except('logout');
    }

    /**
     * Show Register Form
     *
     * @return \Inertia\Response|Response
     */
    public function showRegisterForm()
    {
        if ($loginPath = config('nova.routes.login', false)) {
            return Inertia::location($loginPath);
        }

        return Inertia::render('Nova.Register', [
            'privacyText' => __('Accept :privacy', ['privacy' => '<a href="https://huth.it/privacy" target="_blank" class="link-default">'.__('privacy policy').'</a>']),
        ]);
    }

    /**
     * Handle Register Request
     *
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email', 'max:254', 'unique:users,email', 'confirmed'],
            'name'     => ['required', 'min:3', 'max:30', 'string', 'unique:users,name', 'alpha_dash'],
            'password' => ['required', Password::default(), 'confirmed'],
            'privacy'  => ['accepted'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => __('Register failed'),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);


        /**
         * Notify Email Verification
         * https://laravel.com/docs/9.x/verification
         */
        //$user->sendEmailVerificationNotification();

        Auth::login($user);

        return true;
    }
}
