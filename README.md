HshnClassMatcherBundle
======================

[![Build Status](https://travis-ci.org/hshn/HshnClassMatcherBundle.svg?branch=travis)](https://travis-ci.org/hshn/HshnClassMatcherBundle)

Make easy to define class matcher as a service in Symfony.

## Configure

```yaml
# app/config/config.yml
hshn_class_matcher:
    matchers:
        matcher1: { equals: FooExtended }       # matches FooExtended
        matcher2: { implemented: FooInterface } # matches class that implements FooInterface
        matcher3: { extended: Foo }             # matches class that extends Foo
        matcher4: { anything: ~ }               # matches anything
        matcher5: { and: [matcher1, matcher3 }  # matches class that matches matcher 'matcher1' and 'matcher3'
        matcher6: { or: [matcher1, matcher2] }  # matches class that matches matcher 'matcher1' or 'matcher2'
        matcher7: { not: matcher3 }             # matches class that do not extends Foo
```

## Usage

```php
<?php
$provider = $container->get('hshn_class_matcher.matcher_provider');
$provider->get('matcher1')->matches('Foo'); // true or false
```
