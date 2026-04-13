<?php

namespace Onetoweb\Winstore\Model\Models;

use Onetoweb\Winstore\Model\AbstractModel;

/**
 * Order Model.
 */
class Order extends AbstractModel
{
    public const ROOT_NODE_NAME = 'order';
    
    /**
     * @var string
     */
    private $ordernr;
    
    /**
     * @var DateTime
     */
    private $orderdate;
    
    /**
     * @var int
     */
    private $customerid = 999999;
    
    /**
     * @var string
     */
    private $fname;
    
    /**
     * @var string
     */
    private $lname;
    
    /**
     * @var string
     */
    private $street;
    
    /**
     * @var string
     */
    private $streetnr;
    
    /**
     * @var string
     */
    private $zip;
    
    /**
     * @var string
     */
    private $city;
    
    /**
     * @var string
     */
    private $country = 'Nederland';
    
    /**
     * @var string
     */
    private $countryISO = 'NL';
    
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var int
     */
    private $branch;
    
    /**
     * @var string
     */
    private $channel;
    
    /**
     * @var float
     */
    private $total;
    
    /**
     * @var string
     */
    private $currency = 'EUR';
    
    /**
     * @var string
     */
    private $changeSavingPoints;
    
    /**
     * @var array
     */
    private $products = [];
    
    public function build()
    {
        $this->checkAndRemoveRootNode(self::ROOT_NODE_NAME);
        
        $order = $this->createElement(self::ROOT_NODE_NAME);
        
        $order->appendChild($this->createElement('ordernr', $this->ordernr));
        $order->appendChild($this->createElement('orderdate', $this->orderdate->format('Y-m-d H:i:s')));
        $order->appendChild($this->createElement('customerid', $this->customerid));
        
        
        $order->appendChild($this->createElement('email', $this->email));
        $order->appendChild($this->createElement('branch', $this->branch));
        $order->appendChild($this->createElement('channel', $this->channel));
        $order->appendChild($this->createElement('total', $this->total));
        $order->appendChild($this->createElement('currency', $this->currency));
        
        if ($this->changeSavingPoints !== null) {
            $order->appendChild($this->createElement('changeSavingPoints', $this->changeSavingPoints));
        }
        
        $invoiceAdd = $this->createElement('invoice_add');
        
        $invoiceAdd->appendChild($this->createElement('fname', $this->fname));
        $invoiceAdd->appendChild($this->createElement('lname', $this->lname));
        $invoiceAdd->appendChild($this->createElement('street', $this->street));
        $invoiceAdd->appendChild($this->createElement('streetnr', $this->streetnr));
        $invoiceAdd->appendChild($this->createElement('zip', $this->zip));
        $invoiceAdd->appendChild($this->createElement('country', $this->zip));
        $invoiceAdd->appendChild($this->createElement('countryISO', $this->zip));
        
        $order->appendChild($invoiceAdd);
        
        $positions = $this->createElement('positions');
        
        foreach ($this->products as $product) {
            
            $position = $this->createElement('position');
            
            $position->appendChild($this->createElement('product_id', $product['product_id']));
            $position->appendChild($this->createElement('amount', $product['amount']));
            $position->appendChild($this->createElement('single_price', $product['single_price']));
            $position->appendChild($this->createElement('type', $product['type']));
            $position->appendChild($this->createElement('branch', $product['branch']));
            
            if ($product['reduction']) {
                $position->appendChild($this->createElement('reduction', $product['reduction']));
            }
            
            $positions->appendChild($position);
        }
        
        $order->appendChild($positions);
        
        $this->appendChild($order);
    }
    
    public function addProduct(string $product_id, int $amount, float $single_price, int $branch = null, string $type = 'S', ?string $reduction = null)
    {
        $this->products[] = [
            'product_id' => $product_id,
            'amount' => $amount,
            'single_price' => $single_price,
            'branch' => $branch,
            'type' => $type,
            'reduction' => $reduction,
        ];
    }
    
    public function countProducts(): int
    {
        return count($this->products);
    }
    
    public function setOrdernr(string $ordernr): self
    {
        $this->ordernr = $ordernr;
        
        return $this;
    }
    
    public function setOrderdate(\DateTimeInterface $orderdate): self
    {
        $this->orderdate = $orderdate;
        
        return $this;
    }
    
    public function setCustomerid(int $customerid): self
    {
        $this->customerid = $customerid;
        
        return $this;
    }
    
    public function setFname(string $fname): self
    {
        $this->fname = $fname;
        
        return $this;
    }
    
    public function setLname(string $lname): self
    {
        $this->lname = $lname;
        
        return $this;
    }
    
    public function setStreet(string $street): self
    {
        $this->street = $street;
        
        return $this;
    }
    
    public function setStreetnr(string $streetnr): self
    {
        $this->streetnr = $streetnr;
        
        return $this;
    }
    
    public function setZip(string $zip): self
    {
        $this->zip = $zip;
        
        return $this;
    }
    
    public function setCity(string $city): self
    {
        $this->city = $city;
        
        return $this;
    }
    
    public function setCountry(string $country): self
    {
        $this->country = $country;
        
        return $this;
    }
    
    public function setCountryISO(string $countryISO): self
    {
        $this->countryISO = $countryISO;
        
        return $this;
    }
    
    public function setEmail(string $email): self
    {
        $this->email = $email;
        
        return $this;
    }
    
    public function setBranch(int $branch): self
    {
        $this->branch = $branch;
        
        return $this;
    }
    
    public function setChannel(string $channel): self
    {
        $this->channel = $channel;
        
        return $this;
    }
    
    public function setTotal(float $total): self
    {
        $this->total = $total;
        
        return $this;
    }
    
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        
        return $this;
    }
    
    public function setChangeSavingPoints(string $changeSavingPoints): self
    {
        $this->changeSavingPoints = $changeSavingPoints;
        
        return $this;
    }
    
}

