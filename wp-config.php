// public address WordPress should use in every link
define('WP_HOME', 'https://xhat.com/blog');
define('WP_SITEURL', 'https://xhat.com/blog');
 
// make WordPress see the public request, since the proxy strips /blog
$_SERVER['HTTP_HOST'] = 'xhat.com';
$_SERVER['HTTPS'] = 'on';
$_SERVER['REQUEST_URI'] = '/blog' . $_SERVER['REQUEST_URI'];
