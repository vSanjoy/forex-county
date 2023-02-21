<?php
/*****************************************************/
# Page/Class name   : ApiTemporaryUserTokenMiddleware
# Purpose           : Restriction for temporary users
/*****************************************************/
namespace App\Http\Middleware;
use App\Models\TemporaryUser;
use Closure;
use App;
use Hash;
use Response;

class ApiTemporaryUserTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $functionName = getFunctionNameFromRequestUrl();
        $headers = $request->header();
        $data = [];

        // Token section
        if ( array_key_exists('x-access-token', $headers) ) {
            $headerToken  = $headers['x-access-token'][0];
            // Checking generated-token matched with request token (Before sign in)
            if (Hash::check(env('APP_KEY'), $headerToken)) {
                return $next($request);
            }
            // Checking stored token in temporary users table & matched with request token (After signup-step1)
            else {
                $existToken = TemporaryUser::where(['token' => $headerToken])->count();
                if ($existToken == 0) {
                    if ($functionName == 'signup_step2' || $functionName == 'signup_step3') {
                        return Response::json(generateResponseBodyForSignInSignUp('FC-ATUTM-0001#'.$functionName, $data, trans('custom_api.error_access_token_mismatched'), false, 300));
                    } else {
                        return Response::json(generateResponseBody('FC-ATUTM-0002#'.$functionName, $data, trans('custom_api.error_access_token_mismatched'), false, 300));
                    }
                } else {
                    return $next($request);
                }
            }
        } else {
            if ($functionName == 'signup_step2' || $functionName == 'signup_step3') {
                return Response::json(generateResponseBody('FC-ATUTM-0003#'.$functionName, $data, trans('custom_api.error_access_token_mismatched'), false, 300));
            } else {
                return Response::json(generateResponseBody('FC-ATUTM-0004#'.$functionName, $data, trans('custom_api.error_access_token_not_provided'), false, 100));
            }
        }
    }
}
