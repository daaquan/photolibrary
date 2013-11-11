# PhotoLibrary

Simple [Composer](http://getcomposer.org) library for reading iPhoto '11 .photolibrary packages.

PhotoLibrary tries to be [PSR-0](http://www.php-fig.org/psr/psr-0/), [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) compliant.
Please let me know if it's lacking anywhere. Make sure pull requests are compliant as well.

[Semantic Versioning](http://semver.org/) is used for releases / tags.

## Requirements

* At least PHP 5.3 (namespaces)
* The [CFPropertyList](https://raw.github.com/rodneyrehm/CFPropertyList) library

These requirements are taken care of when installing through [Composer](http://getcomposer.org) / [Packagist](https://packagist.org/packages/robbertkl/photo-library).

## Installation

Either add this to you `composer.json` file:

```json
"require": {
    "robbertkl/iphoto-library": "master-dev"
}
```

or manually include the appriate files from the `classes/` dir.

## Known Limitations

* PhotoLibrary is still very basic (just covers my own needs for now), but could be easily extended
* PhotoLibrary could use A LOT more error checking / input handling
* Currently supports iPhoto '11 libraries only (which should include the new iPhoto released September 2013)
* Reading a reasonably filled iPhoto library can take some time and use up quite some memory (due to a large AlbumData.xml plist file)

## Authors

* Robbert Klarenbeek, <robbertkl@renbeek.nl>

## License

PhotoLibrary is published under the [MIT License](http://www.opensource.org/licenses/mit-license.php), which is included in `LICENSE`.
