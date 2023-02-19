<?php
/**
 * Twig Bundle Installer
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2023 nystudio107
 */

namespace nystudio107\composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class Plugin
 *
 * Plugin is the Composer plugin that handles packages of the type: twig-bundle
 *
 * @author    nystudio107
 * @package   twig-bundle-installer
 * @since     1.1.0
 */
class Plugin implements PluginInterface
{
    // Private Properties
    // =========================================================================

    /**
     * @var Installer
     */
    private $installer;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        // Register the plugin installer
        $this->installer = new Installer($io, $composer, Installer::TWIG_BUNDLE_PACKAGE_TYPE);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }

    /**
     * @inheritdoc
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }

    /**
     * @inheritdoc
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}

