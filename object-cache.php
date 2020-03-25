<?php
/*
Plugin Name: Wordpress OPcache Cache Plugin
Plugin URI: https://github.com/elcobvg/wordpress-opcache
Description: OPcache Object Cache plugin for WordPress. Faster than Redis, Memcache or APC.
Version: 0.2.0
Author: Elco Brouwer von Gonzenbach <elco.brouwer@gmail.com>
Author URI: https://www.linkedin.com/in/elcobrouwervongonzenbach/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Stop direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds data to the cache, if the cache key does not already exist.
 *
 * @param int|string $key    The cache key to use for retrieval later
 * @param mixed      $data   The data to add to the cache store
 * @param string     $group  The group to add the cache to
 * @param int        $expire When the cache data should be expired
 *
 * @return bool False if cache key and group already exist, true on success
 */
function wp_cache_add($key, $data, $group = 'default', $expire = 0)
{
    return WP_Object_Cache::instance()->add($key, $data, $group, $expire);
}


/**
 * Closes the cache.
 *
 * This function has ceased to do anything since WordPress 2.5. The
 * functionality was removed along with the rest of the persistent cache. This
 * does not mean that plugins can't implement this function when they need to
 * make sure that the cache is cleaned up after WordPress no longer needs it.
 *
 * @return bool Always returns True
 */
function wp_cache_close()
{
    return true;
}


/**
 * Decrement numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to decrement the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_decr($key, $offset = 1, $group = 'default')
{
    return WP_Object_Cache::instance()->decr($key, $offset, $group);
}


/**
 * Removes the cache contents matching key and group.
 *
 * @param int|string $key   What the contents in the cache are called
 * @param string     $group Where the cache contents are grouped
 *
 * @return bool True on successful removal, false on failure
 */
function wp_cache_delete($key, $group = 'default')
{
    return WP_Object_Cache::instance()->delete($key, $group);
}


/**
 * Removes all cache items.
 *
 * @return bool False on failure, true on success
 */
function wp_cache_flush()
{
    return WP_Object_Cache::instance()->flush();
}


/**
 * Retrieves the cache contents from the cache by key and group.
 *
 * @param int|string $key    What the contents in the cache are called
 * @param string     $group  Where the cache contents are grouped
 * @param bool       $force  Does nothing with OPcache object cache
 * @param bool       &$found Whether key was found in the cache. Disambiguates a return of false, a storable value.
 *
 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
 */
function wp_cache_get($key, $group = 'default', $force = false, &$found = null)
{
    return WP_Object_Cache::instance()->get($key, $group, $force, $found);
}


/**
 * Retrieve multiple values from cache.
 *
 * Gets multiple values from cache, including across multiple groups
 *
 * Usage: array( 'group0' => array( 'key0', 'key1', 'key2', ), 'group1' => array( 'key0' ) )
 *
 * @param array $groups Array of groups and keys to retrieve
 *
 * @return array Array of cached values as
 *    array( 'group0' => array( 'key0' => 'value0', 'key1' => 'value1', 'key2' => 'value2', ) )
 *    Non-existent keys are not returned.
 */
function wp_cache_get_multi($groups)
{
    return WP_Object_Cache::instance()->get_multi($groups);
}


/**
 * Increment numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to increment the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_incr($key, $offset = 1, $group = 'default')
{
    return WP_Object_Cache::instance()->incr($key, $offset, $group);
}


/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
 */
function wp_cache_init()
{
    $GLOBALS['wp_object_cache'] = WP_Object_Cache::instance();
}


/**
 * Replaces the contents of the cache with new data.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False if not exists, true if contents were replaced
 */
function wp_cache_replace($key, $data, $group = 'default', $expire = 0)
{
    return WP_Object_Cache::instance()->replace($key, $data, $group, $expire);
}


/**
 * Saves the data to the cache.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False on failure, true on success
 */
function wp_cache_set($key, $data, $group = 'default', $expire = 0)
{
    return WP_Object_Cache::instance()->set($key, $data, $group, $expire);
}


/**
 * Switch the internal blog id.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @param int $blog_id Blog ID
 */
function wp_cache_switch_to_blog($blog_id)
{
    WP_Object_Cache::instance()->switch_to_blog($blog_id);
}


/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_global_groups($groups)
{
    WP_Object_Cache::instance()->add_global_groups($groups);
}


/**
 * Pass thru to wp_cache_add_global_groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_non_persistent_groups($groups)
{
    wp_cache_add_global_groups($groups);
}


/**
 * Function was depreciated and now does nothing
 *
 * @return bool Always returns false
 */
function wp_cache_reset()
{
    _deprecated_function(__FUNCTION__, '3.5', 'wp_cache_switch_to_blog()');
    return false;
}


/**
 * WordPress OPcache Object Cache Driver
 *
 * The WordPress Object Cache is used to save on trips to the database.
 * The OPcache Cache stores all of the cache data to PHP OPcache and makes
 * the cache contents available by using a key, which is used to name and
 * later retrieve the cache contents.
 *
 * @author Elco Brouwer von Gonzenbach <elco.brouwer@gmail.com>
 */
class WP_Object_Cache
{

    /**
     * Holds the cached objects.
     *
     * @since 2.0.0
     * @var array
     */
    private $cache = array();

    /**
     * @var string The file cache directory.
     */
    private $directory;

    /**
     * @var string Slug of the current blog name
     */
    private $base_name;


    /**
     * @var bool Stores if OPcache is available.
     */
    private $enabled;


    /**
     * @var int The sites current blog ID. This only
     *    differs if running a multi-site installations
     */
    private $blog_prefix;


    /**
     * @var int Keeps count of how many times the
     *    cache was successfully received from OPcache
     */
    private $cache_hits = 0;


    /**
     * @var int Keeps count of how many times the
     *    cache was not successfully received from OPcache
     */
    private $cache_misses = 0;


    /**
     * @var array Holds a list of cache groups that are
     *    shared across all sites in a multi-site installation
     */
    private $global_groups = array();


    /**
     * @var bool True if the current installation is a multi-site
     */
    private $multisite;

    protected $start_time;


	/**
	 * Makes private properties readable for backward compatibility.
	 *
	 * @since 4.0.0
	 *
	 * @param string $name Property to get.
	 * @return mixed Property.
	 */
	public function __get( $name ) {
		return $this->$name;
	}

	/**
	 * Makes private properties settable for backward compatibility.
	 *
	 * @since 4.0.0
	 *
	 * @param string $name  Property to set.
	 * @param mixed  $value Property value.
	 * @return mixed Newly-set property.
	 */
	public function __set( $name, $value ) {
		return $this->$name = $value;
	}

	/**
	 * Makes private properties checkable for backward compatibility.
	 *
	 * @since 4.0.0
	 *
	 * @param string $name Property to check if set.
	 * @return bool Whether the property is set.
	 */
	public function __isset( $name ) {
		return isset( $this->$name );
	}

	/**
	 * Makes private properties un-settable for backward compatibility.
	 *
	 * @since 4.0.0
	 *
	 * @param string $name Property to unset.
	 */
	public function __unset( $name ) {
		unset( $this->$name );
	}


    /**
     * Singleton. Return instance of WP_Object_Cache
     *
     * @return WP_Object_Cache
     */
    public static function instance(): WP_Object_Cache
    {
        static $inst = null;

        if ($inst === null) {
            $inst = new WP_Object_Cache();
        }

        return $inst;
    }


    /**
     * __clone not allowed
     */
    private function __clone()
    {
    }


    /**
     * Direct access to __construct not allowed.
     */
    public function __construct()
    {
        if (!defined('WP_OPCACHE_KEY_SALT')) {
            /**
             * Set in config if you are using some sort of shared
             * config where base_name is the same on all sites
             */
            define('WP_OPCACHE_KEY_SALT', 'wp-opcache');
        }

        $this->directory   = WP_CONTENT_DIR . '/cache';
        $this->base_name   = basename(ABSPATH);
        $this->enabled     = function_exists('opcache_invalidate')
                && ('cli' !== \PHP_SAPI || filter_var(ini_get('opcache.enable_cli'), FILTER_VALIDATE_BOOLEAN))
                && filter_var(ini_get('opcache.enable'), FILTER_VALIDATE_BOOLEAN);
        $this->multisite   = is_multisite();
        $this->blog_prefix = $this->multisite ? get_current_blog_id() . ':' : '';
        $this->start_time  = $_SERVER['REQUEST_TIME'] ?? time();
    }


    /**
     * Adds data to the cache, if the cache key does not already exist.
     *
     * @param int|string $key   The cache key to use for retrieval later
     * @param mixed      $var   The data to add to the cache store
     * @param string     $group The group to add the cache to
     * @param int        $ttl   When the cache data should be expired
     *
     * @return bool False if cache key and group already exist, true on success
     */
    public function add($key, $var, $group = 'default', $ttl = 0): bool
    {
        if (wp_suspend_cache_addition() || $this->exists($key, $group)) {
            return false;
        }
        return $this->set($key, $var, $group, $ttl);
    }


    /**
     * Sets the list of global groups.
     *
     * @param string|array $groups List of groups that are global.
     */
    public function add_global_groups($groups)
    {
        $groups = (array) $groups;

        $groups = array_fill_keys($groups, true);

        $this->global_groups = array_merge($this->global_groups, $groups);
    }


    /**
     * Decrement numeric cache item's value
     *
     * @param int|string $key    The cache key to decrement
     * @param int        $offset The amount by which to decrement the item's value. Default is 1.
     * @param string     $group  The group the key is in.
     *
     * @return false|int False on failure, the item's new value on success.
     */
    public function decr($key, $offset = 1, $group = 'default')
    {
        return $this->incr($key, $offset * -1, $group);
    }


    /**
     * Remove the contents of the cache key in the group
     *
     * If the cache key does not exist in the group, then nothing will happen.
     *
     * @param int|string $key        What the contents in the cache are called
     * @param string     $group      Where the cache contents are grouped
     * @param bool       $deprecated Deprecated.
     *
     * @return bool False if the contents weren't deleted and true on success
     */
    public function delete($key, $group = 'default', $deprecated = false): bool
    {
        unset($deprecated);

	    if ( empty( $group ) ) {
		    $group = 'default';
	    }

	    if ( ! $this->exists( $key, $group ) ) {
		    return false;
	    }

	    if ( $this->multisite && ! isset($this->global_groups[ $group ])) {
		    $key = $this->blog_prefix . $key;
	    }

	    unset( $this->cache[ $group ][ $key ] );

        if ($this->enabled) {
            opcache_invalidate($this->filePath($key, $group), true);
        }
        return unlink($this->filePath($key, $group));
    }


    /**
     * Checks if the cached OPcache key exists
     *
     * @param string $key What the contents in the cache are called
     * @param string $group Where the cache contents are grouped
     *
     * @return bool True if cache key exists else false
     */
    private function exists($key, $group): bool
    {
	    if ( $this->multisite && ! isset($this->global_groups[ $group ])) {
		    $key = $this->blog_prefix . $key;
	    }

	    if (isset($this->cache[ $group ]) && ( isset($this->cache[ $group ][ $key ]) || array_key_exists($key, $this->cache[ $group ]))) {
            return true;
        }

	    return ($this->enabled && opcache_is_script_cached($this->filePath($key, $group)))
               || file_exists($this->filePath($key, $group));
    }


    /**
     * Clears the object cache of all data
     *
     * @return bool Always returns true
     */
    public function flush(): bool
    {
	    $this->cache = array();

	    $directories = array( $this->directory );
	    while( $directory_name = array_pop( $directories ) ) {
		    $dir_handle = opendir( $directory_name );

		    if( $dir_handle) {
			    while ( false !== ( $file = readdir( $dir_handle ) ) ) {
				    if ( ( '.' !== $file ) && ( '..' !== $file ) ) {
					    $full = $directory_name . '/' . $file;
					    if ( is_dir( $full ) ) {
						    array_push( $directories, $full );
					    } else {
						    unlink( $full );
						    if ( $this->enabled ) {
							    opcache_invalidate( $full );
						    }
					    }
				    }
			    }

			    closedir( $dir_handle );
		    }
	    }
//	    rmdir( $directory_name );

	    return true;
    }

    /**
     * Retrieves the cache contents, if it exists
     *
     * The contents will be first attempted to be retrieved by searching by the
     * key in the cache key. If the cache is hit (success) then the contents
     * are returned.
     *
     * On failure, the number of cache misses will be incremented.
     *
     * @param int|string $key   What the contents in the cache are called
     * @param string     $group Where the cache contents are grouped
     * @param bool       $force Not used.
     * @param bool       &$success
     *
     * @return bool|mixed False on failure to retrieve contents or the cache contents on success
     */
    public function get($key, $group = 'default', $force = false, &$success = null)
    {
        if (! $key) {
            $success = false;
            return false;
        }
        if (empty($group)) {
            $group = 'default';
        }

        if ( $this->multisite && ! isset($this->global_groups[ $group ])) {
            $key = $this->blog_prefix . $key;
        }

        if (isset($this->cache[ $group ]) && ( isset($this->cache[ $group ][ $key ]) || array_key_exists($key, $this->cache[ $group ]) )) {
            $success             = true;
            $this->cache_hits += 1;
            if (is_object($this->cache[ $group ][ $key ])) {
                return clone $this->cache[ $group ][ $key ];
            } else {
                return $this->cache[ $group ][ $key ];
            }
        }

        $result = @include $this->filePath($key, $group);
        if (false === $result) {
            // file did not exist.
            $success = false;
            $var =  false;
        } else {
            $success = true;
            list( $exp, $var ) = $result;

            if (is_object($var)) {
                $this->cache[ $group ][ $key ] = clone $var;
            } else {
                $this->cache[ $group ][ $key ] = $var;
            }

            if ($exp < time()) {
                // cache expired.
                $var = false;
                $success = false;
            }
        }

        if ($success) {
            $this->cache_hits++;
        } else {
            $this->cache_misses++;
        }

        return $var;
    }


    /**
     * Retrieve multiple values from cache.
     *
     * Gets multiple values from cache, including across multiple groups
     *
     * Usage: array( 'group0' => array( 'key0', 'key1', 'key2', ), 'group1' => array( 'key0' ) )
     *
     * @param array $groups Array of groups and keys to retrieve
     *
     * @return array Array of cached values as
     *    array( 'group0' => array( 'key0' => 'value0', 'key1' => 'value1', 'key2' => 'value2', ) )
     *    Non-existent keys are not returned.
     */
    public function get_multi($groups): array
    {
        if (empty($groups) || !is_array($groups)) {
            return array();
        }

        $vars    = array();
        $success = false;

        foreach ($groups as $group => $keys) {
            $vars[$group] = array();

            foreach ($keys as $key) {
                $var = $this->get($key, $group, false, $success);

                if ($success) {
                    $vars[$group][$key] = $var;
                }
            }
        }

        return $vars;
    }


    /**
     * Increment numeric cache item's value
     *
     * @param int|string $key    The cache key to increment
     * @param int        $offset The amount by which to increment the item's value. Default is 1.
     * @param string     $group  The group the key is in.
     *
     * @return false|int False on failure, the item's new value on success.
     */
    public function incr($key, $offset = 1, $group = 'default')
    {
        if (!$this->exists($key, $group)) {
            return false;
        }

        $value = $this->get($key, $group);
        if ( ! is_numeric( $value ) ) {
        	$value = 0;
        }

        $offset = (int) $offset;

        $value += $offset;

        if ( $value < 0 ) {
        	$value = 0;
        }
        return $this->set($key, $value, $group) ? $value : false;
    }


    /**
     * Replace the contents in the cache, if contents already exist
     *
     * @param int|string $key   What to call the contents in the cache
     * @param mixed      $var   The contents to store in the cache
     * @param string     $group Where to group the cache contents
     * @param int        $ttl   When to expire the cache contents
     *
     * @return bool False if not exists, true if contents were replaced
     */
    public function replace($key, $var, $group = 'default', $ttl = 0): bool
    {
        if (!$this->exists($key, $group)) {
            return false;
        }

        return $this->set($key, $var, $group, $ttl);
    }


    /**
     * Sets the data contents into the cache
     *
     * @param int|string $key   What to call the contents in the cache
     * @param mixed      $var   The contents to store in the cache
     * @param string     $group Where to group the cache contents
     * @param int        $ttl   When the cache data should be expired
     *
     * @return bool True if cache set successfully else false
     */
    public function set($key, $var, $group = 'default', $ttl = 0): bool
    {
        if (empty($group)) {
            $group = 'default';
        }

        if (is_object($var)) {
            $var = clone $var;
        }

	    if ( $this->multisite && ! isset($this->global_groups[ $group ])) {
		    $key = $this->blog_prefix . $key;
	    }

        $this->cache[ $group ][ $key ] = $var;

        $ttl = max(intval($ttl), 0);

        $has_object = false;

        if ( is_array($var) ) {
            array_walk_recursive(
                $var,
		        function ($value) use (&$has_object) {
                    if ( is_object($value) && ! method_exists($value, '__set_state') && ! $value instanceof stdClass ) {
                        $has_object = true;
                        return false;
                    }
                }
            );
        }
        if ( $has_object || ( is_object($var) && ! method_exists($var, '__set_state') && ! $var instanceof stdClass ) ) {
            $var = serialize($var);
            $var = var_export($var, true);
            $var = 'unserialize('.$var.')';
        } else {
            $var = var_export($var, true);
        }

        // HHVM fails at __set_state, so just use object cast for now
        $var = str_replace('stdClass::__set_state', '(object)', $var);

        return $this->writeFile($key, $group, $this->expiration($ttl), $var);
    }


    /**
     * Switch the internal blog id.
     *
     * This changes the blog id used to create keys in blog specific groups.
     *
     * @param int $blog_id Blog ID
     */
    public function switch_to_blog($blog_id)
    {
        $blog_id           = (int) $blog_id;
        $this->blog_prefix = $this->multisite ? $blog_id . ':' : '';
    }


    /**
     * Get fully qualified file path
     *
     * @param  string  $key
     * @param  string  $group
     * @return string
     */
    protected function filePath($key, $group): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . $group . DIRECTORY_SEPARATOR . WP_OPCACHE_KEY_SALT . '-' . md5( $this->base_name . $key) . '.php';
    }


    /**
     * Write the cache file to disk
     *
     * @param   string $key
     * @param   string $group
     * @param   int    $exp
     * @param   mixed  $var
     * @return  bool
     */
    protected function writeFile($key, $group, $exp, $var): bool
    {
	    // Write to temp file first to ensure atomicity. Use crc32 for speed
        $tmp = $this->directory . '/' . crc32($key) . '-' . uniqid('', true) . '.tmp';
        file_put_contents($tmp, '<?php return array('. $exp . ',' . $var . ');', LOCK_EX);
        $file_path = $this->filePath( $key, $group );

        $dir = dirname( $file_path );
	    if ( ! file_exists($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        touch($file_path, $this->start_time - 10);
        $return = rename($tmp, $file_path);

        if ($this->enabled) {
            @opcache_invalidate($file_path, true);
            @opcache_compile_file($file_path);
        }
        return $return;
    }


    /**
     * Get the expiration time based on the given seconds.
     *
     * @param  float|int  $seconds
     * @return int
     */
    protected function expiration($seconds): int
    {
        return $seconds === 0 ? 99999999999 : strtotime('+' . $seconds . ' seconds');
    }

    /**
     * @return boolean
     */
    public function get_opcache_enabled(): bool
    {
        return $this->enabled;
    }
}
