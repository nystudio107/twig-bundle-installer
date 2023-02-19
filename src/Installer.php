<?php
/**
 * Twig Bundle Installer
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2023 nystudio107
 */

namespace nystudio107\composer;

use Composer\Composer;
use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller as BaseLibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem;
use React\Promise\PromiseInterface;

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
     * @inheritdoc
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
    public function supports($packageType): bool
    {
        return $packageType === self::TWIG_BUNDLE_PACKAGE_TYPE;
    }

    /**
     * @inheritdoc
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        // Install the twig bundle like a normal Composer package
        $promise = parent::install($repo, $package);
        // Write out the .gitignore file
        $this->writeGitIgnore();
        // Composer v2 might return a promise
        if ($promise instanceof PromiseInterface) {
            return $promise;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        // Install the twig bundle like a normal Composer package
        $promise = parent::update($repo, $initial, $target);
        // Write out the .gitignore file
        $this->writeGitIgnore();
        // Composer v2 might return a promise
        if ($promise instanceof PromiseInterface) {
            return $promise;
        }
        return null;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Write out a .gitignore file in the TEMPLATES_VENDOR_DIR if it doesn't exist already
     *
     * @return void
     */
    protected function writeGitIgnore(): void
    {
        // Create the directory if it doesn't exist
        $dir = self::TEMPLATES_VENDOR_DIR;
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }
        // Create the .gitignore file if it doesn't exist
        $file = self::TEMPLATES_VENDOR_DIR . '/.gitignore';
        if (!file_exists($file)) {
            file_put_contents($file, "*\n!.gitignore\n");
        }
    }
}
