<?php

class OpcacheUnitTestsGet extends OpcacheUnitTests
{
    public function test_get_value()
    {
        $key = microtime();
        $value = 'brodeur';

        // Add string to Opcache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify correct value is returned
        $this->assertSame($value, $this->object_cache->get($key));
    }

    public function test_get_value_twice()
    {
        $key = microtime();
        $value = 'brodeur';

        // Add string to Opcache
        $this->assertTrue($this->object_cache->add($key, $value));

        // Verify correct value is returned
        $this->assertSame($value, $this->object_cache->get($key));

        // Verify correct value is returned when pulled from the internal cache
        $this->assertSame($value, $this->object_cache->get($key));
    }

    public function test_get_value_with_group()
    {
        $key = microtime();
        $value = 'brodeur';

        $group = 'devils';

        // Add string to Opcache
        $this->assertTrue($this->object_cache->add($key, $value, $group));

        // Verify correct value is returned
        $this->assertSame($value, $this->object_cache->get($key, $group));
    }

    public function test_get_value_with_found_indicator()
    {
        $key = microtime();
        $value = 'karlson';
        $group = 'senators';
        $found = false;

        // Add string to Opcache
        $this->assertTrue($this->object_cache->add($key, $value, $group));

        // Verify correct value is returned
        $this->assertSame($value, $this->object_cache->get($key, $group, false, $found));

        // Verify that found variable is set to true because the item was found
        $this->assertTrue($found);
    }

    public function test_get_value_with_found_indicator_when_value_is_not_found()
    {
        $key = microtime();
        $value = 'neil';
        $group = 'senators';
        $found = false;

        // Add string to Opcache
        $this->assertTrue($this->object_cache->add($key, $value, $group));

        // Verify that the value is deleted
        $this->assertTrue($this->object_cache->delete($key, $group));

        // Verify that false is returned
        $this->assertNull($this->object_cache->get($key, $group, false, $found));

        // Verify that found variable is set to true because the item was found
        $this->assertTrue($found);
    }
}
