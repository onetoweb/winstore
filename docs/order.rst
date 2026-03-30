.. _top:
.. title:: Order

`Back to index <index.rst>`_

=====
Order
=====

.. contents::
    :local:


Post order with status code
```````````````````````````

.. code-block:: php
    
    use Onetoweb\Winstore\Model\Models\Order;
    
    // build order
    $order = (new Order())
        ->setOrdernr('Test-001')
        ->setOrderdate(new DateTime())
        ->setCustomerid('999999')
        ->setFname('Pieter')
        ->setLname('Demo')
        ->setStreet('Teststraat')
        ->setStreetnr('Teststraat')
        ->setStreetnr('33')
        ->setZip('1234 AZ')
        ->setCity('Eindhoven')
        ->setEmail('RealMail@RealMailServer.COM')
        ->setBranch(1)
        ->setChannel('Eindhoven')
        ->setTotal(9.99)
        ->setChangeSavingPoints('+10')
    ;
    
    // add product to order
    $productId = '999999999999';
    $amount = 1;
    $singlePrice = 9.99;
    $branch = 1;
    $type = 'S';
    $reduction = '8';
    
    $order->addProduct($productId, $amount, $singlePrice, $branch, $type, $reduction);


`Back to top <#top>`_