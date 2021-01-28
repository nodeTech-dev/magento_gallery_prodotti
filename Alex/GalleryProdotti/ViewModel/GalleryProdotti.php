<?php

namespace Alex\GalleryProdotti\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class GalleryProdotti implements ArgumentInterface {

    /** @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory */

    protected $categoryCollectionFactory;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    //Restituisce un array contenente i nomi delle categorie (come chiavi) e la collezione di prodotti associato ad ogni categoria
    public function getGallery() {
        $gallery = [];
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*');
        //Ottiene collezione di prodotti per ogni categoria
        foreach ($categoryCollection as $category) {
            //Verifica che non sia un categoria root
            if($category->isInRootCategoryList()) {
                //Individua nome della categoria come chiave
                $categoryName = $category->getName();
                $gallery[$categoryName] = [];
                //Ottiene i prodotti
                $productCollection = $category->getProductCollection()->addAttributeToSelect('*');
                foreach($productCollection as $product) {
                    array_push($gallery[$categoryName], $product);
                }
            }
        }
        return $gallery;
    }
}