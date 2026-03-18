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
 * Scans a folder for supported image and video files and returns a URL and
 * media type for a randomly selected file — mirroring the approach used by
 * Joomla's own mod_random_image while adding video background support.
 */
class MokoHeroHelper
{
    /** Image extensions rendered via CSS background-image. */
    private const IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

    /**
     * Video extensions rendered via an HTML <video> element.
     * mp4 (H.264) has near-universal browser support; webm (VP9/AV1) is the
     * open alternative. ogg/ogv is kept for legacy completeness.
     */
    private const VIDEO_TYPES = ['mp4', 'webm', 'ogg', 'ogv'];

    /**
     * Resolve a random media file from the configured folder.
     *
     * Returns an array with two keys:
     *   'url'  — root-relative URL string, or '' when nothing is found
     *   'type' — 'image' | 'video' | ''
     *
     * @param   Registry  $params  Module parameters.
     *
     * @return  array{url: string, type: string}
     */
    public static function getRandomMedia(Registry $params): array
    {
        // The folderlist field stores only the subfolder name (e.g. "headers"),
        // relative to its `directory` attribute ("images"). Reconstruct the full
        // site-root-relative path for filesystem resolution and public URL.
        $subfolder = trim((string) $params->get('folder', 'headers'), '/\\ ');

        if ($subfolder === '') {
            return ['url' => '', 'type' => ''];
        }

        $folder   = 'images/' . $subfolder;
        $basePath = JPATH_SITE . '/' . $folder;

        if (!is_dir($basePath)) {
            Factory::getApplication()->enqueueMessage(
                sprintf('mod_moko_hero: folder "%s" does not exist. Check the Image Folder parameter.', $folder),
                'warning'
            );

            return ['url' => '', 'type' => ''];
        }

        $files = self::scanFolder($basePath);

        if (empty($files)) {
            return ['url' => '', 'type' => ''];
        }

        $chosen   = $files[array_rand($files)];
        $ext      = strtolower(pathinfo($chosen, PATHINFO_EXTENSION));
        $mediaType = in_array($ext, self::VIDEO_TYPES, true) ? 'video' : 'image';
        $url      = Uri::root(true) . '/' . $folder . '/' . $chosen;

        return ['url' => $url, 'type' => $mediaType];
    }

    /**
     * Scan a directory and return filenames matching image or video types.
     *
     * @param   string  $path  Absolute filesystem path.
     *
     * @return  string[]
     */
    private static function scanFolder(string $path): array
    {
        $supported = array_merge(self::IMAGE_TYPES, self::VIDEO_TYPES);
        $files     = [];

        try {
            $iterator = new \DirectoryIterator($path);
        } catch (\Exception $e) {
            return [];
        }

        foreach ($iterator as $file) {
            if ($file->isDot() || !$file->isFile()) {
                continue;
            }

            if (in_array(strtolower($file->getExtension()), $supported, true)) {
                $files[] = $file->getFilename();
            }
        }

        return $files;
    }
}
