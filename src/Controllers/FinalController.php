<?php

namespace Cardei\LaravelWebInstaller\Controllers;

use Illuminate\Routing\Controller;
use Cardei\LaravelWebInstaller\Events\LaravelWebInstallerFinished;
use Cardei\LaravelWebInstaller\Helpers\EnvironmentManager;
use Cardei\LaravelWebInstaller\Helpers\FinalInstallManager;
use Cardei\LaravelWebInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Cardei\LaravelWebInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Cardei\LaravelWebInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Cardei\LaravelWebInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelWebInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
