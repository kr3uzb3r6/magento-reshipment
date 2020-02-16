<?php

namespace NoCompany\Reshipment\Plugin\Sales\Model\Order\Shipment\Validation;

use Magento\Sales\Model\Order\Shipment\Validation\QuantityValidator;
use Magento\Sales\Api\OrderRepositoryInterface;
use NoCompany\Reshipment\Helper\Data;

/**
 * Class QuantityValidator
 * @package NoCompany\Reshipment\Plugin\Sales\Model\Order\Shipment\Validation
 */
class QuantityValidatorPlugin
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * QuantityValidatorPlugin constructor.
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param QuantityValidator $subject
     * @param $result
     * @return array
     */
    public function afterValidate(QuantityValidator $subject, $result)
    {
        if(!$this->helper->isModuleEnabled()) {
            return $result;
        }

        return [];
    }
}
