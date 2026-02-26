.. _top:
.. title:: Supplier

`Back to index <index.rst>`_

========
Supplier
========

.. contents::
    :local:


List suppliers
``````````````

.. code-block:: php
    
    $result = $client->supplier->list();


List suppliers articles
```````````````````````

.. code-block:: php
    
    $id = 42;
    $result = $client->supplier->articles($id);


`Back to top <#top>`_