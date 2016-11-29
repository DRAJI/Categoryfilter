<?php
/**
 * @copyright Copyright (c) 2016 https://chillydraji.wordpress.com
 */
namespace Chilly\Productsgrid\Model\Category;

class Categorylist implements \Magento\Framework\Option\ArrayInterface
{
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory
    ) {
        $this->_categoryCollectionFactory = $collectionFactory;
        
    }

    public function toOptionArray($addEmpty = true)
    {
		
        /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $collection */
        $collection = $this->_categoryCollectionFactory->create();

        $collection->addAttributeToSelect('name');//->addRootLevelFilter()->load();

        $options = [];

        if ($addEmpty) {
            $options[] = ['label' => __('-- Please Select a Category --'), 'value' => ''];
        }
        foreach ($collection as $category) {
            $options[] = ['label' => $category->getName(), 'value' => $category->getId()];
        }

        return $options;
    }
}
