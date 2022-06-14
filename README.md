# Laravel Package Skeleton

[![tests](https://github.com/descom-es/laravel-package-skeleton/actions/workflows/tests.yml/badge.svg)](https://github.com/descom-es/laravel-package-skeleton/actions/workflows/tests.yml)
[![analyse](https://github.com/descom-es/laravel-package-skeleton/actions/workflows/analyse.yml/badge.svg)](https://github.com/descom-es/laravel-package-skeleton/actions/workflows/analyse.yml)
[![style](https://github.com/descom-es/laravel-package-skeleton/actions/workflows/style.yml/badge.svg)](https://github.com/descom-es/laravel-package-skeleton/actions/workflows/style.yml)

After clone this package, you can replace in all files content `Skeleton` with
your Custom NameSpace.

sample:

```bash
find {src,tests,database,config,stubs,composer.json} -type f -exec sed -I '' 's/Skeleton/CustomPackage/g' {} \;
find {src,tests,database,config,stubs,composer.json} -type f -exec sed -I '' 's/skeleton/custom_package/g' {} \;
mv src/SkeletonServiceProvider.php src/CustomPackageServiceProvider.php
composer dump
./vendor/bin/phpunit
```
