# wordpress-opcache
OPcache Object Cache plugin for WordPress. Faster than Redis, Memcache or APC.

## Description ##

This plugin provides a PHP OPcache based driver for the WordPress object cache.

An object cache is a place for WordPress and WordPress extensions to store the results of complex operations. On subsequent loads,
this data can be fetched from the cache, which will be must faster than dynamically generating it on every page load.

Be sure to read the installation instructions, as this is **not** a traditional plugin, and needs to be installed in a specific location.

This method is **faster** than Redis, Memcache, APC, and other PHP caching solutions because all those solutions must serialize and unserialize objects. By storing PHP objects in file cache memory across requests, this driver can avoid serialization completely!

## Installation

1. Verify that you have the PHP OPcache extension installed. (see below)
2. Copy `object-cache.php` to your WordPress content directory (`wp-content/` by default). *This is a drop-in file, not a plugin, so it belongs in the wp-content directory, not the plugins directory.*
3. Done!

### OPcache configuration

OPcache can only be compiled as a shared extension. You **must** compile PHP with the `--enable-opcache` option for OPcache to be available.

OPcache must be enabled and configured in your php.ini. Look for the section starting with `[OPcache]` and enter the desired values. The more memory you can assign to OPcache, the faster your cache will be. The `opcache.max_accelerated_files` value should be high enough to hold all objects that need to be cached. 

Since *all* PHP files will be cached with OPcache, it is not advisable to use it in a development environment, so only enable it in production. Alternatively, you can exclude PHP files from being cached by specifying a blacklist file with the `opcache.blacklist_filename` option. 

```shell
  opcache.enable=1
  opcache.memory_consumption=512
  opcache.interned_strings_buffer=64
  opcache.max_accelerated_files=32500
  opcache.validate_timestamps=1
  opcache.save_comments=1
  opcache.revalidate_freq=60
  opcache.fast_shutdown=1
  opcache.enable_cli=1
```

**Graceful degradation:** when OPcache is not enabled or installed, or memory is insufficient, this driver will still work but will read from the cached files instead of from memory. Since there's no unserialization required, it will still be faster than a regular file cache driver.

### References

- [500X Faster Caching than Redis/Memcache/APC in PHP & HHVM](https://blog.graphiq.com/500x-faster-caching-than-redis-memcache-apc-in-php-hhvm-dcd26e8447ad)
- [PHP OPcache Documentation](http://php.net/manual/en/book.opcache.php)
- [Pecl::Package::ZendOpcache](http://pecl.php.net/package/ZendOpcache)