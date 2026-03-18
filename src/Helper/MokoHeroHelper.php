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
 * Scans a folder for supported image and video files.
 * Returns either a single random item (random mode) or the full list
 * with resolved URLs (slideshow mode).
 */
class MokoHeroHelper
{
    /** Image extensions — rendered via CSS background-image. */
    private const IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

    /**
     * Video extensions — rendered via an HTML <video> element.
     * mp4 (H.264) has near-universal browser support; webm (VP9/AV1) is the
     * open-codec alternative. ogg/ogv retained for legacy completeness.
     */
    private const VIDEO_TYPES = ['mp4', 'webm', 'ogg', 'ogv'];

    /** MIME type map for <video> source elements. */
    private const VIDEO_MIME = [
        'mp4'  => 'video/mp4',
        'webm' => 'video/webm',
        'ogg'  => 'video/ogg',
        'ogv'  => 'video/ogg',
    ];

    /**
     * Return all media items from the configured folder as an array of
     * ['url' => string, 'type' => 'image'|'video', 'mime' => string] maps.
     *
     * The caller decides whether to use the full list (slideshow) or pick one
     * at random (single-image mode).  Returns an empty array on error.
     *
     * @param   Registry  $params  Module parameters.
     *
     * @return  array<int, array{url: string, type: string, mime: string}>
     */
    public static function getAllMedia(Registry $params): array
    {
        // folderlist field stores only the subfolder name (e.g. "headers"),
        // relative to its `directory` attribute ("images").
        $subfolder = trim((string) $params->get('folder', 'headers'), '/\\ ');

        if ($subfolder === '') {
            return [];
        }

        $folder   = 'images/' . $subfolder;
        $basePath = JPATH_SITE . '/' . $folder;

        if (!is_dir($basePath)) {
            Factory::getApplication()->enqueueMessage(
                sprintf('mod_moko_hero: folder "%s" does not exist. Check the Image Folder parameter.', $folder),
                'warning'
            );

            return [];
        }

        $filenames = self::scanFolder($basePath);

        if (empty($filenames)) {
            return [];
        }

        $base = Uri::root(true) . '/' . $folder . '/';
        $items = [];

        foreach ($filenames as $filename) {
            $ext  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $type = in_array($ext, self::VIDEO_TYPES, true) ? 'video' : 'image';
            $mime = $type === 'video' ? (self::VIDEO_MIME[$ext] ?? 'video/mp4') : '';

            $items[] = [
                'url'  => $base . $filename,
                'type' => $type,
                'mime' => $mime,
            ];
        }

        return $items;
    }

    /**
     * Convenience wrapper: return a single random media item or an empty array.
     *
     * @param   Registry  $params  Module parameters.
     *
     * @return  array{url: string, type: string, mime: string}|array{}
     */
    public static function getRandomMedia(Registry $params): array
    {
        $all = self::getAllMedia($params);

        if (empty($all)) {
            return [];
        }

        return $all[array_rand($all)];
    }

    /**
     * Scan a directory and return filenames that match supported image/video types.
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
