<?php

class OpcacheUnitTestsDelete extends OpcacheUnitTests
{
    public function test_delete_key()
    {
        $key = microtime();

        $value = 'sasquatch';
        $value2  = 'yeti';

        // Verify set
        $this->assertTrue($this->object_cache->set($key, $value));

        // Verify value
        $this->assertSame($value, $this->object_cache->get($key));

        // Verify delete
        $this->assertTrue($this->object_cache->delete($key));

        // Verify that key is not gettable after delete
        $this->assertFalse($this->object_cache->get($key));

        // Verify that I can add a new value with this key
        $this->assertTrue($this->object_cache->add($key, $value2));

        // Verify the new value
        $this->assertSame($value2, $this->object_cache->get($key));
    }

    public function test_delete_key_from_group()
    {
        $key = microtime();

        $value = 'sasquatch';
        $value2  = 'yeti';

        $group = 'comment';

        // Verify set
        $this->assertTrue($this->object_cache->set($key, $value, $group));

        // Verify value
        $this->assertSame($value, $this->object_cache->get($key, $group));

        // Verify delete
        $this->assertTrue($this->object_cache->delete($key, $group));

        // Verify that key is not gettable after delete
        $this->assertFalse($this->object_cache->get($key, $group));

        // Verify that I can add a new value with this key
        $this->assertTrue($this->object_cache->add($key, $value2, $group));

        // Verify the new value
        $this->assertSame($value2, $this->object_cache->get($key, $group));
    }
}
