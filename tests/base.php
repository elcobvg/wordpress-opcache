<?php

class OpcacheUnitTests extends WP_UnitTestCase
{
    public $plugin_slug = 'opcache-unit-tests';

    public $object_cache;

    public $servers;

    public $test_cache;

    public function setUp()
    {
        // Instantiate the core cache tests and use that setup routine
        $this->test_cache = new Tests_Cache();
        $this->test_cache->setUp();

        $this->object_cache = $this->test_cache->cache;
    }

    public function tearDown()
    {
        $this->test_cache->tearDown();
    }


	/**
	 * Flushes the WordPress object cache.
	 */
	public static function flush_cache() {
		global $wp_object_cache;
		$wp_object_cache->group_ops      = array();
		$wp_object_cache->stats          = array();
		$wp_object_cache->memcache_debug = array();
//		$wp_object_cache->cache          = array();
		if ( method_exists( $wp_object_cache, '__remoteset' ) ) {
			$wp_object_cache->__remoteset();
		}
		wp_cache_flush();
		wp_cache_add_global_groups( array( 'users', 'userlogins', 'usermeta', 'user_meta', 'useremail', 'userslugs', 'site-transient', 'site-options', 'blog-lookup', 'blog-details', 'rss', 'global-posts', 'blog-id-cache', 'networks', 'sites', 'site-details', 'blog_meta' ) );
		wp_cache_add_non_persistent_groups( array( 'comment', 'counts', 'plugins' ) );
	}


	/**
	 * Runs the routine after all tests have been run.
	 */
	public static function tearDownAfterClass() {
		PHPUnit_Framework_TestCase::tearDownAfterClass();

		_delete_all_data();
		self::flush_cache();

		$c = get_called_class();
		if ( ! method_exists( $c, 'wpTearDownAfterClass' ) ) {
			self::commit_transaction();
			return;
		}

		call_user_func( array( $c, 'wpTearDownAfterClass' ) );

		self::commit_transaction();
	}

	/**
	 * Cleans the global scope (e.g `$_GET` and `$_POST`).
	 */
	public function clean_up_global_scope() {
		$_GET  = array();
		$_POST = array();
		self::flush_cache();
	}

}
