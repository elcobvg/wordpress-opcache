<?php

class OpcacheUnitTestsAdd extends OpcacheUnitTests
{
    /**
     * Verify "add" method with string as value
     */
    public function test_add_string()
    {
        $key = microtime();
        $value = 'brodeur';

        // Add string to Opcache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify correct value is returned
        $this->assertSame($value, $this->object_cache->get($key));
    }

    /**
     * Verify "add" method with int as value
     */
    public function test_add_int()
    {
        $key = microtime();
        $value = 42;

        // Add int to Opcache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify correct value and type is returned
        $this->assertSame($value, $this->object_cache->get($key));
    }

    /**
     * Verify "add" method with array as value
     */
    public function test_add_array()
    {
        $key = microtime();
        $value = array( 5, 'quick' );

        // Add array to Opcache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify correct value and type is returned
        $this->assertSame($value, $this->object_cache->get($key));
    }

    /**
     * Verify "add" method values when adding second object with existing key
     */
    public function test_add_fails_if_key_exists()
    {
        $key = microtime();
        $value1 = 'parise';
        $value2 = 'king';

        // Verify that one value is added to cache
        $this->assertTrue($this->object_cache->add($key, $value1));

        // Make sure second value with same key fails
        $this->assertFalse($this->object_cache->add($key, $value2));

        // Make sure the value of the key is still correct
        $this->assertSame($value1, $this->object_cache->get($key));
    }

    /**
     * Verify that wp_suspend_cache_addition() stops items from being added to cache
     */
    public function test_add_suspended_by_wp_cache_suspend_addition_string()
    {
        $key = microtime();
        $value = 'crawford';

        // Suspend the cache
        wp_suspend_cache_addition(true);

        // Attempt to add string to cache
        $this->assertFalse($this->object_cache->add($key, $value));

        // Verify that the value does not exist in cache
        $this->assertFalse($this->object_cache->get($key));
    }

    /**
     * Verify that wp_suspend_cache_addition() stops items from being added to cache, but allows additions after re-enabled
     */
    public function test_add_enabled_by_wp_cache_un_suspend_addition_string()
    {
        $key = microtime();
        $value = 'miller';

        // Suspend the cache
        wp_suspend_cache_addition(true);

        // Attempt to add string to cache
        $this->assertFalse($this->object_cache->add($key, $value));

        // Verify that the value does not exist in cache
        $this->assertFalse($this->object_cache->get($key));

        $key = microtime();
        $value = 'carruth';

        // Re-enable the cache
        wp_suspend_cache_addition(false);

        // Add the string to the cache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify that the value is in the cache
        $this->assertSame($value, $this->object_cache->get($key));
    }

    public function test_add_with_expiration_of_30_days()
    {
        $key = 'usa';
        $value = 'merica';
        $group = 'july';

        // 30 days
        $expiration = 60 * 60 * 24 * 30;

        $this->assertTrue($this->object_cache->add($key, $value, $group, $expiration));

        $this->assertEquals($value, $this->object_cache->get($key, $group));
    }

    public function test_add_with_expiration_longer_than_30_days()
    {
        $key = 'usa';
        $value = 'merica';
        $group = 'july';

        // 30 days and 1 second; if interpreted as timestamp, becomes "Sat, 31 Jan 1970 00:00:01 GMT"
        $expiration = 60 * 60 * 24 * 30 + 1;

        $this->assertTrue($this->object_cache->add($key, $value, $group, $expiration));

        // Verify that the value is in cache
        $this->assertEquals($value, $this->object_cache->get($key, $group));
    }
}
