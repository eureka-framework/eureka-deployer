<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Installer\Script;

use Eureka\Component\Installer\Common\AbstractInstallerScript;
use Eureka\Eurekon;

/**
 * Class Install
 *
 * @author Romain Cottard
 */
class Install extends AbstractInstallerScript
{
    /**
     * Install constructor.
     */
    public function __construct()
    {
        $this->setDescription('Eureka Installer');
        $this->setExecutable(true);
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $stepStart = $this->config['install']['step.start'] ?? 0;
        $stepEnd   = $this->config['install']['step.end'] ?? 100;

        foreach ($this->config['install']['step.list'] as $step => $script) {
            if ($step < $stepStart) {
                continue;
            }

            if ($step > $stepEnd) {
                break;
            }

            $stringStep = str_pad((string) $step, 3, '0', STR_PAD_LEFT);
            $this->runStep($stringStep, $script);
        }
    }

    /**
     * @param string $step
     * @param string $script
     * @return void
     */
    private function runStep(
        string $step,
        string $script
    ): void {
        $this->startTimer();

        $scriptArg   = escapeshellarg($script);
        $stepArg     = '--step=' . escapeshellarg($step);
        $platformArg = '--platform=' . escapeshellarg($this->getAppPlatform());
        $tagArg      = '--tag=' . escapeshellarg($this->getAppTag());
        $nameArg     = '--app=' . escapeshellarg($this->getAppName());
        $domainArg   = '--domain=' . escapeshellarg($this->getAppDomain());

        passthru("bin/console ${scriptArg} ${stepArg} ${platformArg} ${tagArg} ${nameArg} ${domainArg}", $status);

        if ($status === 0) {
            $this->displaySuccess($script);
        } else {
            $this->displayError($script);
        }
    }
}
