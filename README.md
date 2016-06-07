redkiwi-nl/local-config
======================



[![Build Status](https://travis-ci.org/Redkiwi-NL/local-config.svg?branch=master)](https://travis-ci.org//Redkiwi-NL/local-config)

Quick links: [Installing](#installing) | [Examples](#examples) | [Contributing](#contributing)

## Installing

Installing this package requires WP-CLI v0.23.0 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with `wp package install redkiwi-nl/localconfig`

## Examples

```
wp local-config create
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
