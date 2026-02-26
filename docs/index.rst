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
    $username = 'username';
    $password  = 'password';
    
    // setup client
    $client = new Client($username, $password);


========
Examples
========

* `Supplier <supplier.rst>`_
* `Article <article.rst>`_
* `Stock <stock.rst>`_
