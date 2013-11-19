# PhotoLibrary

[![Latest Stable Version](https://poser.pugx.org/robbertkl/photolibrary/v/stable.png)](https://packagist.org/packages/robbertkl/photolibrary)

PHP library for reading iPhoto '11 .photolibrary packages.
Since v0.2.0, it includes caching capabilities (using Zend\Cache) for relatively large photo libraries.

PhotoLibrary is [PSR-0](http://www.php-fig.org/psr/psr-0/), [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) compliant.

[Semantic Versioning](http://semver.org/) is used for releases / tags.

## Requirements

* PHP 5.3 or newer
* The [CFPropertyList](https://raw.github.com/rodneyrehm/CFPropertyList) library

## Installation

The easiest way to install is using [Composer](http://getcomposer.org) / [Packagist](https://packagist.org/packages/robbertkl/photolibrary) by adding this to you `composer.json` file:

```json
"require": {
    "robbertkl/photolibrary": "master-dev"
}
```

Alternatively, you could manually include/autoload the appriate files from the `classes/` dir.

## Documentation

See the [examples/](examples/) dir for usage examples.
Also, check out the [API documentation](http://robbertkl.github.io/photolibrary/), generated using [ApiGen](http://apigen.org).

## Known Limitations

* PhotoLibrary is still very basic (just covers my own needs for now), but could be easily extended
* PhotoLibrary could use more error checking / input handling
* Currently supports iPhoto '11 libraries only (which includes the new iPhoto released September 2013)
* Reading a reasonably filled iPhoto library can take some time and use up quite some memory (due to a large AlbumData.xml plist file)

## Authors

* Robbert Klarenbeek, <robbertkl@renbeek.nl>

## License

PhotoLibrary is published under the [MIT License](http://www.opensource.org/licenses/mit-license.php), which is included in `LICENSE`.
