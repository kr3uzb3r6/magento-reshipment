<?php

namespace NoCompany\Reshipment\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package NoCompany\Reshipment\Helper
 */
class Data
{
    const XML_PATH_MODULE_ENABLED = 'shipping/reshipment_setting/enable';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfigInterface;

    /**
     * Data constructor.
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfigInterface = $scopeConfigInterface;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled()
    {
        $isEnabled = $this->scopeConfigInterface->getValue(
            self::XML_PATH_MODULE_ENABLED,
            ScopeInterface::SCOPE_STORE
        );

        return (bool) $isEnabled;
    }

    /**
     * @param string $key
     * @param array $arr
     * @return bool
     */
    public function findKeyInArray(string $key, array $arr)
    {
        if (array_key_exists($key, $arr)) {
            return true;
        }

        foreach ($arr as $item) {
            if (is_array($item)) {
                if ($this->findKeyInArray($key, $item)) {
                    return true;
                }
            }
        }

        return false;
    }
}
