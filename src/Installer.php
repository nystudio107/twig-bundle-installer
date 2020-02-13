<?php
/**
 * Twig Bundle Installer
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2020 nystudio107
 */

namespace nystudio107\composer;

use Composer\Composer;
use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller as BaseLibraryInstaller;

use Composer\IO\IOInterface;
use Composer\Util\Filesystem;

/**
 * Class Installer
 *
 * Installer is the Composer Installer that handles packages of the type: twig-bundle
 *
 * @author    nystudio107
 * @package   bundle-installer
 * @since     1.0.0
 */
class Installer extends BaseLibraryInstaller
{
    // Constants
    // =========================================================================

    const TEMPLATES_VENDOR_DIR = './templates/vendor';
    const TWIG_BUNDLE_PACKAGE_TYPE = 'twig-bundle';

    // Public Methods
    // =========================================================================

    /**
     * Initializes library installer.
     *
     * @param IOInterface     $io
     * @param Composer        $composer
     * @param string          $type
     * @param Filesystem      $filesystem
     * @param BinaryInstaller $binaryInstaller
     */
    public function __construct(IOInterface $io, Composer $composer, $type = self::TWIG_BUNDLE_PACKAGE_TYPE, Filesystem $filesystem = null, BinaryInstaller $binaryInstaller = null)
    {
        parent::__construct($io, $composer, $type, $filesystem, $binaryInstaller);
        $this->vendorDir = rtrim(self::TEMPLATES_VENDOR_DIR, '/');
        $this->type = self::TWIG_BUNDLE_PACKAGE_TYPE;
    }

    /**
     * @inheritdoc
     */
    public function supports($packageType)
    {
        return $packageType === self::TWIG_BUNDLE_PACKAGE_TYPE;
    }
}
