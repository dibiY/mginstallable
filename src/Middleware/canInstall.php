<?php

namespace mgInstallable\installable\Middleware;

use Closure;
use Redirect;

class canInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->alreadyInstalled()) {
            $installedRedirect = config('Installable.installedAlreadyAction');

            switch ($installedRedirect) {

                case 'route':
                    $routeName = config('Installable.installed.redirectOptions.route.name');
                    $data = config('Installable.installed.redirectOptions.route.message');

                    return redirect()->route($routeName)->with(['data' => $data]);
                    break;

                case 'abort':
                    abort(config('Installable.installed.redirectOptions.abort.type'));
                    break;

                case 'dump':
                    $dump = config('Installable.installed.redirectOptions.dump.data');
                    dd($dump);
                    break;

                case '404':
                case 'default':
                default:
                    abort(404);
                    break;
            }
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}
