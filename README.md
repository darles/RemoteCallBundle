DarlesRemoteCallBundle
=============

The DarlesRemoteCallBundle adds links to quick open current Controller, Template & Entities in PHPStorm IDE
using RemoteCall Plugin (http://plugins.jetbrains.com/plugin/6027?pr=phpStorm) in Symfony2 profiler toolbar.

Demo
----

* https://www.dropbox.com/s/dfcvdmrbtvpyt51/remote_call_bundle_example.png
* http://www.youtube.com/watch?v=fV5G2sVM0hw


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
        new Darles\Bundle\RemoteCallBundle\DarlesRemoteCallBundle(),
    );
}
```

- Open your Symfony2 application in dev environment, you should see "Open in PHPStorm" tab in profiler toolbar.

License
-------

This bundle is under the MIT license.

XDebug & RemoteCall
-------------------

Enable RemoteCall links on your XDebug stack trace by adding this line to your php.ini

``` ini
xdebug.file_link_format="javascript:var rq = new XMLHttpRequest(); rq.open('GET', 'http://localhost:8091?message=%f:%l', true); rq.send(null);"
```
