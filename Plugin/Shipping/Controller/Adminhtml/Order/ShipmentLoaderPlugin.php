<?php

namespace NoCompany\Reshipment\Plugin\Shipping\Controller\Adminhtml\Order;

use Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader;
use NoCompany\Reshipment\Helper\Data as Helper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Sales\Model\Convert\Order;

/**
 * Class ShipmentLoaderPlugin
 * @package NoCompany\Reshipment\Plugin\Shipping\Controller\Adminhtml\Order
 */
class ShipmentLoaderPlugin
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var ObjectManagerInterface
     */
    private $_objectManager;

    /**
     * ShipmentLoaderPlugin constructor.
     * @param Helper $helper
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        Helper $helper,
        ObjectManagerInterface $objectManager
    ) {
        $this->helper = $helper;
        $this->_objectManager = $objectManager;
    }

    /**
     * @param ShipmentLoader $subject
     * @param $result
     * @return mixed
     */
    public function afterLoad(ShipmentLoader $subject, $result)
    {
        if (!$this->helper->isModuleEnabled()) {
            return $result;
        }

        $convertOrder = $this->_objectManager->create(Order::class);

        foreach ($result->getOrder()->getAllItems() AS $orderItem) {
            if ($orderItem->getIsVirtual()) {
                continue;
            }

            $qtyShipped = $this->getItemQty($subject->getData(), $orderItem);
            $shipmentItem = $convertOrder->itemToShipmentItem($orderItem)->setQty($qtyShipped);
            $result->addItem($shipmentItem);
        }

        return $result;
    }

    /**
     * @param $shipmentData
     * @return bool
     */
    private function isUpdateAction($shipmentData)
    {
        return $this->helper->findKeyInArray('items', $shipmentData);
    }

    /**
     * @param array $shipmentData
     * @param $orderItem
     * @return mixed
     */
    private function getItemQty(array $shipmentData, $orderItem)
    {
        if(!$this->isUpdateAction($shipmentData)) {
            return $orderItem->getQtyOrdered();
        }

        foreach ($shipmentData['shipment']['items'] as $key => $qty) {
            if($orderItem->getId() == $key) {
                return $qty;
            }
        }
    }
}
