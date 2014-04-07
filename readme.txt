
Silvercart configurable product

after you install this module in silvercart, the several steps  of modification in the core code.

1 SilvercartProductGroupPage.php
  in init function register addCartForm
  // BBQ 05,04,2014 configurable product register addCartForm
  if($product->IsConfigurableProduct){
      $childrenProducts = $product->ChildrenProducts();

      if($childrenProducts->Count()){
          foreach($childrenProducts as $childproduct){
              $this->registerCustomHtmlForm(
                  'SilvercartProductAddCartFormDetail'.$childproduct->ID,
                  new SilvercartProductAddCartFormDetail(
                      $this,
                      array(
                          'productID'          => $childproduct->ID,
                      )
                  )
              );
          }
      }
  }
  // BBQ 05,04,2014 configurable product register addCartForm


  in getProducts function add condition
                  //BBQ 05,04,2014 add configurable product
                        $filter .= " and IsChildProduct = 0 " ;
                  //BBQ 05,04,2014 add configurable product

2 SilvercartProduct.php
  modify the Link function to configurable product.

  // BBQ 05,04,2014 configurable product
  $configurableProduct = SilvercartConfigurableProductBridge::get_one('SilvercartConfigurableProductBridge' , 'TargetID =' . $this->ID);
  if($configurableProduct){
      $product = DataObject::get_by_id('SilvercartProduct', $configurableProduct->SourceID);
      $link = $this->SilvercartProductGroup()->OriginalLink() . $product->ID . '/' . $product->title2urlSegment();
  }
  // BBQ 05,04,2014 configurable product
