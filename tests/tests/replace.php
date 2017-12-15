<?php

class OpcacheUnitTestsReplace extends OpcacheUnitTests
{
    public function test_replace_value_with_another_value()
    {
        $key = microtime();

        $value1 = 'parise';
        $value2 = 'kovalchuk';

        $this->assertTrue($this->object_cache->add($key, $value1));

        $this->assertSame($value1, $this->object_cache->get($key));

        $this->assertTrue($this->object_cache->replace($key, $value2));

        $this->assertSame($value2, $this->object_cache->get($key));
    }

    public function test_replace_value_when_key_is_not_set()
    {
        $key = microtime();

        $value = 'parise';

        $this->assertFalse($this->object_cache->replace($key, $value));

        $this->assertNull($this->object_cache->get($key));
    }

    public function test_replace_with_expiration_of_30_days()
    {
        $key = 'usa';
        $value = 'merica';
        $group = 'july';
        $built_key = $this->object_cache->buildKey($key, $group);

        $value2 = 'belgium';

        // 30 days
        $expiration = 60 * 60 * 24 * 30;

        $this->assertTrue($this->object_cache->set($key, $value, $group));
        $this->assertTrue($this->object_cache->replace($key, $value2, $group, $expiration));

        // Verify that the value is in cache by accessing Opcache directly
        $this->assertEquals($value2, $this->object_cache->get($key, $group));
    }

    public function test_replace_with_expiration_longer_than_30_days()
    {
        $key = 'usa';
        $value = 'merica';
        $group = 'july';
        $built_key = $this->object_cache->buildKey($key, $group);

        $value2 = 'belgium';

        // 30 days and 1 second; if interpreted as timestamp, becomes "Sat, 31 Jan 1970 00:00:01 GMT"
        $expiration = 60 * 60 * 24 * 30 + 1;

        $this->assertTrue($this->object_cache->set($key, $value, $group));
        $this->assertTrue($this->object_cache->replace($key, $value2, $group, $expiration));

        // Verify that the value is in cache by accessing Opcache directly
        $this->assertEquals($value2, $this->object_cache->get($key, $group));
    }
}
