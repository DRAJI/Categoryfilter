<?php
/**
 * @copyright Copyright (c) 2016 https://chillydraji.wordpress.com
 */
namespace Chilly\Productsgrid\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class Price
 */
class Category extends \Magento\Ui\Component\Listing\Columns\Column
{
	
	protected $_productloader;
	protected $_categoryloader;
	
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Model\ProductFactory $_productloader,
        \Magento\Catalog\Model\Category $_categoryloader,
        array $components = [],
        array $data = []
    ) {
		parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_productloader = $_productloader;
        $this->_categoryloader = $_categoryloader;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
		$fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
			foreach ($dataSource['data']['items'] as & $item) {
				//print_r($item);die;
				$p_id=$item['entity_id'];
				$product=$this->_productloader->create()->load($p_id);
				$cats = $product->getCategoryIds();
				$objectManager   = \Magento\Framework\App\ObjectManager::getInstance();
				$categories=array();
                if(count($cats) ){
					foreach($cats as $cat){
						$category = $objectManager->create('Magento\Catalog\Model\Category')->load($cat);
						$categories[]=$category->getName();
					}
           
        }
        $item[$fieldName]=implode(',',$categories);
			}
		}
        return $dataSource;
    }
}
