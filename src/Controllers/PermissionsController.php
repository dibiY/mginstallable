<?php

namespace mgInstallable\installable\Controllers;

use Illuminate\Routing\Controller;
use mgInstallable\installable\Helpers\PermissionsChecker;

class PermissionsController extends Controller
{
    /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @param PermissionsChecker $checker
     */
    public function __construct(PermissionsChecker $checker)
    {
        $this->permissions = $checker;
    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function permissions()
    {
        $permissions = $this->permissions->check(
            config('Installable.permissions')
        );

        return view('vendor.Installable.permissions', compact('permissions'));
    }
}
