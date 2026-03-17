<?php

/**
 * @package     MokoConsulting.Module
 * @subpackage  mod_moko_hero
 *
 * @copyright   Copyright (C) 2026 Moko Consulting. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

namespace MokoConsulting\Module\MokoHero\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

/**
 * Helper for mod_moko_hero
 *
 * Scans a folder for supported image files and returns a URL to a randomly
 * selected image — mirroring the approach used by Joomla's own mod_random_image.
 */
class MokoHeroHelper
{
    /**
     * Supported image extensions (matches mod_random_image defaults).
     */
    private const SUPPORTED_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

    /**
     * Return a root-relative URL for a random image found in the configured folder.
     *
     * Returns an empty string when the folder is empty or inaccessible so that
     * the template can degrade gracefully (e.g. show a solid colour fallback).
     *
     * @param   Registry  $params  Module parameters.
     *
     * @return  string  Root-relative URL, e.g. "/images/headers/hero.jpg", or empty string.
     */
    public static function getRandomImageUrl(Registry $params): string
    {
        // The folderlist field stores only the subfolder name (e.g. "headers"),
        // relative to its `directory` attribute ("images"). Reconstruct the full
        // site-root-relative path so we can resolve both the filesystem path and
        // the public URL consistently.
        $subfolder = trim((string) $params->get('folder', 'headers'), '/\\ ');

        if ($subfolder === '') {
            return '';
        }

        $folder   = 'images/' . $subfolder;

        // Build the absolute filesystem path relative to the Joomla root.
        $basePath = JPATH_SITE . '/' . $folder;

        if (!is_dir($basePath)) {
            Factory::getApplication()->enqueueMessage(
                sprintf('mod_moko_hero: folder "%s" does not exist. Check the Image Folder parameter.', $folder),
                'warning'
            );

            return '';
        }

        $images = self::scanFolder($basePath);

        if (empty($images)) {
            return '';
        }

        $chosen = $images[array_rand($images)];

        // Return a root-relative URL safe for use in CSS background-image.
        return Uri::root(true) . '/' . $folder . '/' . $chosen;
    }

    /**
     * Scan a directory and return filenames that match supported image types.
     *
     * @param   string  $path  Absolute filesystem path.
     *
     * @return  string[]  Flat array of filenames (no path prefix).
     */
    private static function scanFolder(string $path): array
    {
        $images = [];

        try {
            $iterator = new \DirectoryIterator($path);
        } catch (\Exception $e) {
            return [];
        }

        foreach ($iterator as $file) {
            if ($file->isDot() || !$file->isFile()) {
                continue;
            }

            $ext = strtolower($file->getExtension());

            if (in_array($ext, self::SUPPORTED_TYPES, true)) {
                $images[] = $file->getFilename();
            }
        }

        return $images;
    }
}
