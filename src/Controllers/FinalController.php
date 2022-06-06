<?php

namespace mgInstallable\installable\Controllers;

use Illuminate\Routing\Controller;
use mgInstallable\installable\Events\InstallableFinished;
use mgInstallable\installable\Helpers\EnvironmentManager;
use mgInstallable\installable\Helpers\FinalInstallManager;
use mgInstallable\installable\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \mgInstallable\installable\Helpers\InstalledFileManager $fileManager
     * @param \mgInstallable\installable\Helpers\FinalInstallManager $finalInstall
     * @param \mgInstallable\installable\Helpers\EnvironmentManager $environment
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
