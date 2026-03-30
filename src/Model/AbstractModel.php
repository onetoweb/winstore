<?php

namespace Onetoweb\Winstore\Model;

use Onetoweb\Winstore\Model\ModelInterface;
use DOMDocument;

/**
 * Abstract Command.
 */
abstract class AbstractModel extends DOMDocument implements ModelInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('1.0', 'UTF-8');
        
        $this->formatOutput = true;
    }
    
    /**
     * @param string $nodeName
     */
    public function checkAndRemoveRootNode(string $nodeName)
    {
        if ($this->childNodes->count() > 0) {
            
            $rootNode = $this->childNodes->item(0);
            
            if ($rootNode->nodeName === $nodeName) {
                
                $this->removeChild($rootNode);
            }
        }
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        $this->formatOutput = false;
        
        return $this->saveXml();
    }
}

