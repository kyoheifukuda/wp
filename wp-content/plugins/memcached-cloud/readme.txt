=== Memcached Cloud ===

Contributors: Redis Labs
Tags: cache, Memcached Cloud, Memcached, SASL, binary protocol, cache, object cache, WP Object Cache
Requires at least: 3.4
Tested up to: 3.9.1
Stable tag: 1.0

Use Memcached with SASL authentication to implement WP Object Cache

== Description ==

Changed the [wordpress-memcached-backend](https://github.com/tollmanz/wordpress-memcached-backend) backend to use [Memcached ver. 2.2.0 PECL package](http://pecl.php.net/package/memcached) with SASL authentication support, to implement WP Object Cache.

Inehernt support for [Memcached Cloud](http://redislabs.com/memcached-cloud) on Heroku and AppFog- just add the Memcached Cloud add-on.

== Credits ==

We used the [wordpress-memcached-backend](https://github.com/tollmanz/wordpress-memcached-backend), so all credit goes to Zack Tollman.

== Installation ==

1. Make sure you have [libmemcached](http://libmemcached.org/libMemcached.html) installed, built with SASL. See the [Memcached Requirements](http://il1.php.net/manual/en/memcached.requirements.php). 

2. Install the [Memcached ver. 2.2.0 PECL package](http://il1.php.net/manual/en/memcached.installation.php).

3. Define the Memcached servers and SASL credentials in your wp-config.php, as follows:


		global $memcached_servers;
		$memcached_servers = array( array( 'host', port ) );

		global $memcached_username;
		$memcached_username = 'sasl_username';

		global $memcached_password;
		$memcached_password = 'sasl_password';


**Note:** If running on Heroku or AppFog, just install the Memcached Cloud add-on and your conifguration environment variables will be set.  

4. Move object-cache.php to wp-content/object-cache.php

== Examples ==

1.

	wp_cache_set('key', 'val');  
	wp_cache_get('key');

2.

	wp_cache_set_multi ( 
		array ( 'key1' => 'val1', 'key2' => 'val2', 'key3' => 'val3' ), 
		'group1' 
	);  
	
	wp_cache_get_multi ( 
		array ( 'key1', 'key2' ), 
		'group1' 
	);

== Changelog ==

= 1.0 =
* Initial release