<?php

namespace Flipmediaco\TagServeTracking\Model\Config\Source;

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
                ['label' => __('Commission Category 1'), 'value' => 'CAT1'],
                ['label' => __('Commission Category 2'), 'value' => 'CAT2'],
                ['label' => __('Commission Category 3'), 'value' => 'CAT3'],
                ['label' => __('Commission Category 4'), 'value' => 'CAT4'],
                ['label' => __('Commission Category 5'), 'value' => 'CAT5'],
                ['label' => __('Commission Category 6'), 'value' => 'CAT6'],
                ['label' => __('Commission Category 7'), 'value' => 'CAT7'],
                ['label' => __('Commission Category 8'), 'value' => 'CAT8'],
                ['label' => __('Commission Category 9'), 'value' => 'CAT9'],
        ];
        return $this->_options;
    }
}
