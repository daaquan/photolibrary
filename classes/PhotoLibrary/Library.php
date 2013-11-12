<?php
/**
 * File containing the \PhotoLibrary\Library class
 *
 * @author Robbert Klarenbeek <robbertkl@renbeek.nl>
 * @copyright Copyright (c) 2013, Robbert Klarenbeek
 * @package photolibrary
 */

namespace PhotoLibrary;

/**
 * Main class for accessing an iPhoto .photolibrary package
 * @package photolibrary
 */
class Library
{
    /**
     * Path to the library on this filesystem
     * @var string
     */
    protected $path;

    /**
     * The plist data from AlbumData.xml as array
     * @var array
     */
    protected $data;

    /**
     * Associative array (int => Album) of cached Album objects by ID
     * @var array
     */
    protected $albums = null;

    /**
     * Create new Library from a path
     * @param string $path path to the .photolibrary directory (with or without trailing /)
     */
    public function __construct($path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $plist = $path . DIRECTORY_SEPARATOR . 'AlbumData.xml';
        
        if (!is_dir($path) || !file_exists($plist)) {
            throw new \InvalidArgumentException('Given path does not seem to be an iPhoto library package');
        }

        $this->path = $path;

        $plist = new \CFPropertyList\CFPropertyList($plist);
        $this->data = $plist->toArray();
    }

    /**
     * Ensure the album cache ($this->albums) is filled with albums of this library
     */
    protected function ensureAlbums()
    {
        if (is_null($this->albums)) {
            $this->albums = array();
            foreach ($this->data['List of Albums'] as &$albumData) {
                $album = new Album($this, $albumData);
                $this->albums[$album->getId()] = $album;
            }
        }
    }

    /**
     * Get all albums in this library
     * @return Album[] list of Album objects
     */
    public function getAlbums()
    {
        $this->ensureAlbums();
        return array_values($this->albums);
    }

    /**
     * Get all albums of a specific "Album Type"
     * @param string $type album type to look for, e.g. "Flagged", "Regular", "Event"
     * @return Album[] list of Album objects
     */
    public function getAlbumsOfType($type)
    {
        $this->ensureAlbums();
        $albums = array();
        foreach ($this->albums as $id => $album) {
            if ($album->getType() == $type) {
                $albums[] = $album;
            }
        }
        return $albums;
    }

    /**
     * Get an album by its "Album ID"
     * @param int $id Album ID of the album to get
     * @return Album album with the given ID, or null iff not found
     */
    public function getAlbum($id)
    {
        $this->ensureAlbums();
        if (!array_key_exists($id, $this->albums)) {
            return null;
        }
        return $this->albums[$id];
    }

    /**
     * Get a photo by its key
     * @param int $key key of the photo to get
     * @return Photo photo with the given key, or null iff not found
     */
    public function getPhoto($key)
    {
        if (!array_key_exists($key, $this->data['Master Image List'])) {
            return null;
        }
        return new Photo($this, $key, $this->data['Master Image List'][$key]);
    }

    /**
     * Rewrite an internal photolibrary path (called the "Archive Path" to the real one on disk
     * @param string $path path to a file from the AlbumData.xml plist
     * @return string rewritten path to the real file (of the current .photolibrary)
     */
    public function rewritePath($path)
    {
        $archivePath = dirname($this->data['Archive Path']);
        $realPath = dirname($this->path);
        return preg_replace('/^' . preg_quote($archivePath, '/') . '/', $realPath, $path);
    }
}
