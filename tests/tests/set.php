<?php

class OpcacheUnitTestsSet extends OpcacheUnitTests
{
    public function test_set_value()
    {
        $key = microtime();

        $value = 'ck';

        $this->assertTrue($this->object_cache->set($key, $value));

        $this->assertSame($value, $this->object_cache->get($key));
    }

    public function test_set_value_with_expiration()
    {
        $key = microtime();

        $value = 'ck';

        $this->assertTrue($this->object_cache->set($key, $value, 'default', 3600));

        $this->assertSame($value, $this->object_cache->get($key));
    }

    public function test_set_value_overwrites_previous()
    {
        $key = microtime();

        $value = 'ck';
        $new_value = 'abc';

        $this->assertTrue($this->object_cache->set($key, $value));

        $this->assertSame($value, $this->object_cache->get($key));

        $this->assertTrue($this->object_cache->set($key, $new_value));

        $this->assertSame($new_value, $this->object_cache->get($key));
    }

    public function test_set_value_group()
    {
        $key = microtime();

        $value = 'ck';
        $group = 'hola';

        $this->assertTrue($this->object_cache->set($key, $value, $group));

        $this->assertSame($value, $this->object_cache->get($key, $group));
    }

    public function test_set_with_expiration_of_30_days()
    {
        $key = 'usa';
        $value = 'merica';
        $group = 'july';
        $built_key = $this->object_cache->buildKey($key, $group);

        // 30 days
        $expiration = 60 * 60 * 24 * 30;

        $this->assertTrue($this->object_cache->set($key, $value, $group, $expiration));

        // Do the lookup with the API to verify that we get the value
        $this->assertEquals($value, $this->object_cache->get($key, $group));
    }

    public function test_set_with_expiration_longer_than_30_days()
    {
        $key = 'usa';
        $value = 'merica';
        $group = 'july';
        $built_key = $this->object_cache->buildKey($key, $group);

        // 30 days and 1 second; if interpreted as timestamp, becomes "Sat, 31 Jan 1970 00:00:01 GMT"
        $expiration = 60 * 60 * 24 * 30 + 1;

        $this->assertTrue($this->object_cache->set($key, $value, $group, $expiration));

        // Do the lookup with the API to verify that we get the value
        $this->assertEquals($value, $this->object_cache->get($key, $group));
    }
}
