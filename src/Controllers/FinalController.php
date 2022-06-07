<?php

namespace Dibiy\MgInstallable\Controllers;

use Illuminate\Routing\Controller;
use Dibiy\MgInstallable\Events\InstallableFinished;
use Dibiy\MgInstallable\Helpers\EnvironmentManager;
use Dibiy\MgInstallable\Helpers\FinalInstallManager;
use Dibiy\MgInstallable\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Dibiy\MgInstallable\Helpers\InstalledFileManager $fileManager
     * @param \Dibiy\MgInstallable\Helpers\FinalInstallManager $finalInstall
     * @param \Dibiy\MgInstallable\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new InstallableFinished);

        return view('vendor.installable.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
