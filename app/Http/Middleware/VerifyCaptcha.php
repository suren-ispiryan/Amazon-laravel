<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class VerifyCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $rule = [
            $request['g-recaptcha-response'] => [new GoogleReCaptchaV3ValidationRule('action_name')]
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->toArray(),$rule)->errors();
        log::info($validator->toArray());
        return $next($request);
    }
}
