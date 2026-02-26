.. _top:
.. title:: Stock

`Back to index <index.rst>`_

=====
Stock
=====

.. contents::
    :local:


Get by artikel key
``````````````````

.. code-block:: php
    
    $id = 42;
    $result = $client->stock->getByArtikelKey($id);


Get by artikel gtin
```````````````````

.. code-block:: php
    
    $gtin = '010053790105';
    $result = $client->stock->getByGtin($id);


Get changed by
``````````````

.. code-block:: php
    
    $changedBy = (new DateTime())->modify('-1 day');
    $result = $client->stock->getChangedBy($changedBy);


Get changed by with warehouse
`````````````````````````````

.. code-block:: php
    
    $changedBy = (new DateTime())->modify('-1 day');
    $result = $client->stock->getChangedByWithWarehouse($changedBy);


`Back to top <#top>`_