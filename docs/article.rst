.. _top:
.. title:: Article

`Back to index <index.rst>`_

=======
Article
=======

.. contents::
    :local:


Get articles changed by
```````````````````````

.. code-block:: php
    
    $changedBy = (new DateTime())->modify('-1 day');
    $result = $client->article->getChangedBy($changedBy);


`Back to top <#top>`_