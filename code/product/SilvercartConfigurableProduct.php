<?php
/**
 * Copyright 2014 stilbezirk Gmbh
 *
 * 03,04,2014
 *
 * Bingquan.bao@gmail.com
 *
 */

/**
 * Extends the SilvercartProduct with variants
 *
 * @package SilvercartConfigurableProduct
 * @subpackage Products
 * @author Bingquan Bao <bingquan.bao@gmail.com>
 * @since 04.03.2014
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @Copyright 2014 stilbezirk Gmbh
 */


class SilvercartConfigurableProduct extends DataObjectDecorator{

    /**
     * List of children products
     *
     * @var DataObjectSet
     */
    protected $childProducts = null;

    /**
     * Decorates attributes
     *
     * @return array
     * @author Bingquan Bao <bingquan.bao@gmail.com>
     */
    public function extraStatics() {
        return array(
            'db' => array(
                'IsConfigurableProduct' => 'Boolean(0)',
                'IsChildProduct'     => 'Boolean(0)'
            ),
            'has_many' => array(
                'ConfigurableSourceProducts' => 'SilvercartConfigurableProductBridge.Source',
                'ConfigurableTargetProducts' => 'SilvercartConfigurableProductBridge.Target',
            ),
        );
    }

    /**
     * Updates the CMS fields
     *
     * @param FieldSet $fields
     * @author Bingquan Bao <bingquan.bao@gmail.com>
     */
    public function updateCMSFields(FieldSet &$fields){

        $fields->removeByName('ConfigurableSourceProducts');
        $fields->removeByName('ConfigurableTargetProducts');

        $isConfigurableProduct = new CheckboxField('IsConfigurableProduct', $this->owner->fieldLabel('IsConfigurableProduct'));
        $isChildProduct = new CheckboxField('IsChildProduct', $this->owner->fieldLabel('IsChildProduct'));
        //$childrenProducts = new SilvercartTextField('ChildrenProducts', $this->owner->fieldLabel('ChildrenProducts'));

        $sourceProducts = new SilvercartBridgeTextAutoCompleteField(
            $this->owner,
            'ConfigurableSourceProducts',
            $this->owner->fieldLabel('children Products'),
            'SilvercartProduct.ProductNumberShop'
        );
        $targetProducts = new SilvercartBridgeTextAutoCompleteField(
            $this->owner,
            'ConfigurableTargetProducts',
            $this->owner->fieldLabel('targetProducts'),
            'SilvercartProduct.ProductNumberShop'
        );

        $confiurableProductGroup = new SilvercartFieldGroup('configurableProduct', 'configurableProduct',  $fields );
        $confiurableProductGroup->push($isConfigurableProduct);
        $confiurableProductGroup->push($isChildProduct);
        $confiurableProductGroup->push($sourceProducts);
        //$confiurableProductGroup->push($targetProducts);
        $fields->addFieldToTab('Root.Configurable', $confiurableProductGroup);
    }

    /**
     * list of the children products
     *
     * @return DataObjectSet|mixed
     */
    public function ChildrenProducts(){

        if(is_null($this->childProducts)){
            $this->childProducts  = DataObject::get(
                'SilvercartProduct',
                sprintf(
                    '"SilvercartProduct"."ID" IN (SELECT TargetID FROM SilvercartConfigurableProductBridge WHERE SourceID = %d)',
                    $this->owner->ID
                )
            );
        }
        if($this->childProducts->count()){
            foreach($this->childProducts as $product){
                $sqlResults = DB::query("SELECT SilvercartProductVariantAttributeID
                                        FROM SilvercartAttributedVariantAttributeSet_Attributes sa
                                        INNER JOIN SilvercartAttributedVariantAttributeSet sv ON sv.ID = sa.SilvercartAttributedVariantAttributeSetID
                                        AND SilvercartProductID =$product->ID
                                        WHERE isActive =1");

                if($sqlResults) foreach($sqlResults as $sqlResult) {
                    $product->variant = $sqlResult['SilvercartProductVariantAttributeID'];
                    $cartPositionQuantity = 0;
                    if (Member::currentUser() && Member::currentUser()->SilvercartShoppingCart()) {
                        $cartPositionQuantity = Member::currentUser()->SilvercartShoppingCart()->getQuantity($product->ID);
                    }
                    $product->StockQuantity = $product->StockQuantity - $cartPositionQuantity;
                }
            }
        }

        return $this->childProducts;
    }

}


class SilvercartConfigurableProductBridge extends DataObject{

    /**
     * Has one attributes.
     *
     * @var array
     */
    public static $has_one = array(
        'Source'    => 'SilvercartProduct',
        'Target'    => 'SilvercartProduct',
    );

}