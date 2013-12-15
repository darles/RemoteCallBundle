DarlesRemoteCallBundle
=============

The DarlesRemoteCallBundle adds links to quick open current Controller, Template & Entities in PHPStorm IDE
using RemoteCall Plugin (http://plugins.jetbrains.com/plugin/6027?pr=phpStorm) in Symfony2 profiler toolbar.

Installation
------------

- Install RemoteCall plugin to your PHPStorm IDE

http://plugins.jetbrains.com/plugin/6027?pr=phpStorm

- Add DarlesRemoteCallBundle in your composer.json require-dev section:

```js
{
    "require-dev": {
        "darles/remote-call-bundle": "dev-master"
    }
}
```

- Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Darles\Bundle\RemoteCallBundle\RemoteCallBundle(),
    );
}
```

- Open your Symfony2 application in dev environment, you should see "Open in PHPStorm" tab in profiler toolbar.

License
-------

This bundle is under the MIT license.