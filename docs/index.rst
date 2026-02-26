.. title:: Index

Index
=====

.. contents::
    :local:

===========
Basic Usage
===========

Setup

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\Winstore\Client;
    
    // param
    $apiKey = 'api_key';
    $testModus = true;
    
    // setup client
    $client = new Client($apiKey, $testModus);


========
Examples
========

* `Supplier <supplier.rst>`_
* `Article <article.rst>`_
* `Stock <stock.rst>`_
