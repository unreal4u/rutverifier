[![Latest Stable Version](https://poser.pugx.org/unreal4u/rutverifier/v/stable.png)](https://packagist.org/packages/unreal4u/rutverifier)
[![Build Status](https://travis-ci.org/unreal4u/rutverifier.png?branch=master)](https://travis-ci.org/unreal4u/rutverifier)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/unreal4u/rutverifier/badges/quality-score.png?s=41b9a0c72279222d0e5172565ea4f9944b6c0e5e)](https://scrutinizer-ci.com/g/unreal4u/rutverifier/)
[![License](https://poser.pugx.org/unreal4u/rutverifier/license.png)](https://packagist.org/packages/unreal4u/rutverifier)

rutverifier.php
======

Credits
--------

This class is made by unreal4u (Camilo Sperberg) [Homepage](http://unreal4u.com/)

About this class
--------

* Can be used to verify chilean RUT (Rol único tributario) or RUN (Rol único nacional). (<a href="http://www.registrocivil.cl/PortalOI/html/faq/Cod_Area_4/Cod_Tema_30/pregunta_155.html">Difference</a> [spanish])
* Will give you some information, such as the RUT/RUN being consulted is an enterprise (RUT) or a natural person (RUN).
* Allows you to make use of a blacklist (Useful for known frauders).
* Will also format the RUT/RUN into the correct format.
* Can deliver also a pure (more basic) Javascript coded version to verify the validity of a RUT/RUN

Detailed description
---------

This package will do all kinds of things you can do with a RUT or RUN, such as:

* Verifying that it is valid.
* Finding out whether it is a RUT or a RUN.
* Format it to the correct format to use / store / work with

Basic usage
----------

<pre>include('src/unreal4u/rutverifier.php');
$rutVerifier = new unreal4u\rutverifier();
$result = $rutVerifier->isValidRUT('30.686.957-4');
</pre>
* Congratulations! Result does now contain true or false depending on the RUT/RUN being valid or not.
* **Please see examples for more options and advanced usage**

Composer
----------

This class has support for Composer install. Just add the following section to your composer.json with:

<pre>
{
    "require": {
        "unreal4u/rutverifier": "@stable"
    }
}
</pre>

Now you can instantiate a new rutverifier class by executing:

<pre>
require('vendor/autoload.php');

$rutverifier = new unreal4u\rutverifier();
</pre>

Don't forget to do a <code>composer.phar install</code> or download and include
<code>http://packagist.org/unreal4u/rutverifier-js</code> manually

Pending
---------
* Class will throw exceptions instead of adding silently to an internal error array
* Native i18n support

Version History
----------

* 1.0 :
    * Initial version

* 1.1:
    * PHPUnit testing
    * Documentation improved (Created this README actually)
    * More examples
    * Solved some bugs
* 1.2:
    * Compatibility with composer
    * Better documentation
* 1.2.1:
    * Real compatibility with composer
* 1.2.2:
    * Minor bugs in documentation
* 1.2.4:
    * Documentation
    * Better PHPUnit tests
    * Fixed a bug related to cache and blacklisting
    * Included PHPDocumentor to src code
* 1.2.6:
    * Excluded PHPDocumentation
* 1.2.8:
    * Travis-CI support
    * Very small optimization on Javascript function
    * Began deprecating some old naming conventions
* 2.0.0:
    * Removed c_javascript function
    * Standarized data type on return for all functions, no more mixed types
    * Updated PHPUnit dependency to latest stable version
    * Will now test PHP 5.3 in Travis-CI as well
    * Class will now sprintf into the error array in preparation for later i18n implementation
* 2.1.0:
    * Now checking JavaScript code with grunt
* 2.2.0:
    * This class has now a dependency on unreal4u/rutverifier-js, downloadable on packagist
    * Cleaned up javascript code that had nothing to do with PHP

Contact the author
-------

* Twitter: [@unreal4u](http://twitter.com/unreal4u)
* Website: [http://unreal4u.com/](http://unreal4u.com/)
* Github:  [http://www.github.com/unreal4u](http://www.github.com/unreal4u)
