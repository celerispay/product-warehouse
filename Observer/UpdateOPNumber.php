<?php

namespace Boostsales\ProductWarehouse\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class UpdateOPNumber implements ObserverInterface
{
    
    protected $_productAction;

    /**
     * @param \Magento\Catalog\Model\Product\Action $productAction
     */
    public function __construct(
        \Magento\Catalog\Model\Product\Action $productAction
    ) {
        $this->_productAction = $productAction;
	}
	
   /**
    * Generate order picking number for product
    *
    * @param Observer $observer
    */
   public function execute(Observer $observer)
   {
        $product = $observer->getProduct();
        $productWarehouse = $product->getAttributeText('product_warehouse');
        $this->_productAction->updateAttributes(
            [$product->getId()],
            array('order_picking_number' => $productWarehouse.substr($product->getId()+10000,-6)),
            $product->getStoreId()
        );

    }
}