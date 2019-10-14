<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Installer\Script\Install\Init;

use Eureka\Component\Installer\Common\AbstractInstallerScript;

/**
 * Class Directories
 *
 * @author Romain Cottard
 */
class Directories extends AbstractInstallerScript
{
    /**
     * Directories constructor.
     */
    public function __construct()
    {
        $this->setDescription('Initialize var directories');
        $this->setExecutable(true);
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->createDirectories();
        $this->fixPermissions();
    }

    /**
     * @return void
     */
    private function createDirectories(): void
    {
        $this->displayInfo('Fixing directories... ');
        foreach ($this->config['install']['init']['directories'] as $directory => $perms) {
            $path = $this->rootDir . DIRECTORY_SEPARATOR . $directory;

            var_export($path);
            /*if (!is_dir($path) && !mkdir($path, $perms, true)) {
                $this->displayInfoFailed();
                $this->throw('Cannot create directory: ' . $directory);
            }*/
        }

        $this->displayInfoDone();
    }

    /**
     * @return void
     */
    private function fixPermissions(): void
    {
        $this->displayInfo('Fixing permissions... ');

        foreach ($this->config['install']['init']['directories'] as $directory => $perms) {
            $path = $this->rootDir . DIRECTORY_SEPARATOR . $directory;

            /*if (!chmod($path, 0777)) {
                $this->throw('Cannot fix permissions on directory: ' . $directory);
            }*/
        }

        $this->displayInfoDone();
    }
}
