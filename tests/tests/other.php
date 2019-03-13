<?php

class OpcacheUnitTestsAll extends OpcacheUnitTests
{
    public function test_disabled()
    {
        $this->assertFalse($this->object_cache->getOpcacheEnabled());
    }

    public function test_flush()
    {
        $key = microtime();
        $value = 'brodeur';

        // Add to Opcache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify correct value and type is returned
        $this->assertSame($value, $this->object_cache->get($key));

        // Flush cache
        $this->assertTrue($this->object_cache->flush());

        // Make sure value is no longer available
        $this->assertFalse($this->object_cache->get($key));
    }

    public function test_switch_to_blog()
    {
        $key = 'oshie';
        $val = 'kovalchuk';
        $val2 = 'bobrovsky';

        if (! is_multisite()) {
            // Single site ingnores switch_to_blog().
            $this->assertTrue($this->object_cache->set($key, $val));
            $this->assertEquals($val, $this->object_cache->get($key));
            $this->object_cache->switch_to_blog(999);
            $this->assertEquals($val, $this->object_cache->get($key));
            $this->assertTrue($this->object_cache->set($key, $val2));
            $this->assertEquals($val2, $this->object_cache->get($key));
            $this->object_cache->switch_to_blog(get_current_blog_id());
            $this->assertEquals($val2, $this->object_cache->get($key));
        } else {
            // Multisite should have separate per-blog caches
            $this->assertTrue($this->object_cache->set($key, $val));
            $this->assertEquals($val, $this->object_cache->get($key));
            $this->object_cache->switch_to_blog(999);
            $this->assertFalse($this->object_cache->get($key));
            $this->assertTrue($this->object_cache->set($key, $val2));
            $this->assertEquals($val2, $this->object_cache->get($key));
            $this->object_cache->switch_to_blog(get_current_blog_id());
            $this->assertEquals($val, $this->object_cache->get($key));
            $this->object_cache->switch_to_blog(999);
            $this->assertEquals($val2, $this->object_cache->get($key));
            $this->object_cache->switch_to_blog(get_current_blog_id());
            $this->assertEquals($val, $this->object_cache->get($key));
        }

        // Global group
        $this->object_cache->add_global_groups('global-cache-test');
        $this->assertTrue($this->object_cache->set($key, $val, 'global-cache-test'));
        $this->assertEquals($val, $this->object_cache->get($key, 'global-cache-test'));
        $this->object_cache->switch_to_blog(999);
        $this->assertEquals($val, $this->object_cache->get($key, 'global-cache-test'));
        $this->assertTrue($this->object_cache->set($key, $val2, 'global-cache-test'));
        $this->assertEquals($val2, $this->object_cache->get($key, 'global-cache-test'));
        $this->object_cache->switch_to_blog(get_current_blog_id());
        $this->assertEquals($val2, $this->object_cache->get($key, 'global-cache-test'));
    }
}
