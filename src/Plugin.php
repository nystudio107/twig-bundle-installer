<?php
/**
 * Twig Bundle Installer
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2020 nystudio107
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
 * @package   bundle-installer
 * @since     1.0.0
 */
class Plugin implements PluginInterface
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        // Register the plugin installer
        $installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
