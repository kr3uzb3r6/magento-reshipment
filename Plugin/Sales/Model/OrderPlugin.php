<?php

namespace NoCompany\Reshipment\Plugin\Sales\Model;

use Magento\Sales\Model\Order;
use NoCompany\Reshipment\Helper\Data;

/**
 * Class Order
 * @package NoCompany\Reshipment\Plugin\Sales\Model\Order
 */
class OrderPlugin
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * Order constructor.
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param Order $subject
     * @param $result
     * @return bool
     */
    public function afterCanShip(Order $subject, $result)
    {
        if (!$this->helper->isModuleEnabled()) {
            return $result;
        }

        return true;
    }
}
