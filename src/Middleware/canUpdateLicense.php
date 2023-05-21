<?php

namespace Dibiy\MgInstallable\Middleware;

use Closure;

class canUpdateLicense
{
    use \Dibiy\MgInstallable\Helpers\MigrationsHelper;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $updateEnabled = filter_var(config('Installable.updaterEnabled'), FILTER_VALIDATE_BOOLEAN);
        switch ($updateEnabled) {
            case true:
                $canInstall = new canInstall;

                // if the application has not been installed,
                // redirect to the installer
                if (!$canInstall->alreadyInstalled()) {
                    return redirect()->route('Installable::welcome');
                }

                break;

            case false:
            default:
                abort(404);
                break;
        }

        return $next($request);
    }
}
