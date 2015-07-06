# FeatureToggleBundle

A Symfony2 Bundle implementing the https://github.com/JoshuaEstes/FeatureToggle library

## Install

Install with composer:

```
composer.phar require hotflo/feature-toggle-bundle
```

Add to your `AppKernel.php`

```
new Hotflo\FeatureToggleBundle\HotfloFeatureToggleBundle(),
```

## Configuration

To use this bundle you should configure toggles and feature in the config.yml. You can use a class or a service as
toggle and then use the configured toggles in your features.

Full reference:

```
hotflo_feature_toggle:
    toggles:
        generic:
            class: JoshuaEstes\Component\FeatureToggle\Toggle\FeatureToggleGeneric
            options:
                enabled: true
        generic_service:
            type: service
            service: hotflo_feature_toggle.generic_feature_toggle
    features:
        dashboard:
            toggle: generic_service
```

## Usage

In your controller, the feature container is available in the Symfony2 service container.

Example:

```
$this->get('hotflo_feature_toggle.feature_container')->getFeature('dashboard');
```

The configured feature toggles are also available in the Symfony2 service container.

```
$this->get('hotflo_feature_toggle.feature_toggle_container')->getFeatureToggle('generic');
```

## Test

Start the tests by running PHP Unit:

```
./bin/phpunit
```

## More documentation

This bundle depends on the FeatureToggle library. The documentation of this library can be found here:
http://feature-toggle.readthedocs.org/en/latest/