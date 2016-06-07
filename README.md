redkiwi-nl/local-config
======================



[![Build Status](https://travis-ci.org/Redkiwi-NL/local-config.svg?branch=master)](https://travis-ci.org/Redkiwi-NL/local-config)

Quick links: [Installing](#installing) | [Explanation](#explanation) | [Examples](#examples) | [Contributing](#contributing)

## Installing

Installing this package requires WP-CLI v0.23.0 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with `wp package install redkiwi-nl/localconfig`

## Explanation

A fairly basic package that allows you to create a local config with at least the following constants:
```
'WP_ROOT_URL'
'WP_HOME'
'WP_SITEURL_APPEND'
'DB_NAME'
'DB_USER'
'DB_PASSWORD'
'DB_HOST'
'WP_CACHE'
```

These constants will be asked as a question, to fill in the php document after.

Whereas you can also add extra constants to be filled using [--fields=<fields>], which is comma separated

## Examples

```
wp local-config create
```

```
wp local-config create --file=my_custom_local_config.php
```

```
wp local-config create --fields=extra_constant,another_constant
```

```
wp local-config create --fields=extra_constant,another_constant --fields_lowercase
```

## Contributing

Code and ideas are more than welcome.

Please [open an issue](https://github.com/redkiwi-nl/localconfig/issues) with questions, feedback, and violent dissent. Pull requests are expected to include test coverage.
