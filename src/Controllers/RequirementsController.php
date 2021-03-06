<?php

namespace Dibiy\MgInstallable\Controllers;

use Illuminate\Routing\Controller;
use Dibiy\MgInstallable\Helpers\RequirementsChecker;

class RequirementsController extends Controller
{
    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(
            config('Installable.core.minPhpVersion')
        );
        $requirements = $this->requirements->check(
            config('Installable.requirements')
        );

        return view('vendor.mginstallable.requirements', compact('requirements', 'phpSupportInfo'));
    }
}
