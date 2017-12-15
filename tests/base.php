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
}
