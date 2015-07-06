# FeatureToggleBundle

A Symfony2 Bundle implementing the https://github.com/JoshuaEstes/FeatureToggle library

## Install

Install with composer:

```
composer.phar require hotflo/feature-toggle-bundle
```

## Usage

The feature toggle library is well documented here: http://feature-toggle.readthedocs.org/en/latest/

The feature container is available in the service container:

```
$this->get('hotflo_feature_toggle.container');
```
