<% if IsConfigurableProduct %>
        <% control ChildrenProducts %>
                                <div class="silvercart-product-page-order-box <% if isPriceHigh %>HighPrice<% end_if %>" id="addCart_$variant" style="display:none">
                                    <% if isPriceHigh %>
                                    <img src="/assets/Uploads/Images/style/gratisversand.png" class="yeahsilvercartkotz" alt=""/>
                                    <% end_if %>
                                    <div class="silvercart-product-page-box-price">
                                        <p class="silvercart-price">
                                            $Price.Nice
                                            <!--
                                                                    <% if checkBoard %>
                                    <img src="/assets/Uploads/Images/style/stoerer-drybagpack.png" class="yeahsilvercartkotz" alt=""/>
                                    <% end_if %>

                                            -->
                                        </p>
                                        <small>
                                            <% if CurrentPage.showPricesGross %>
                                                <% sprintf(_t('SilvercartPage.INCLUDING_TAX', 'incl. %s%% VAT'),$TaxRate) %><br />
                                            <% else_if CurrentPage.showPricesNet %>
                                                <% _t('SilvercartPage.EXCLUDING_TAX', 'plus VAT') %><br />
                                            <% end_if %>
                                            <% control Top.PageByIdentifierCode(SilvercartShippingFeesPage) %>
                                                <a href="$Link" title="<% sprintf(_t('SilvercartPage.GOTO', 'go to %s page'),$Title.XML) %>">
                                                    <% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %><br/>
                                                </a>
                                            <% end_control %>
                                        </small>
                                    </div>

                                    <div class="silvercart-product-availability">
                                        <% if isBuyableDueToStockManagementSettings %>
                                                $StockQuantity
                                        <% end_if %>
                                        $Availability
                                    </div>

                                    <div class="silvercart-product-group-add-cart-form" style="">
                                        <div class="silvercart-product-group-add-cart-form_content 	<% if isBuyableDueToStockManagementSettings %> buy <% else %> notBuy <% end_if %>">

                                                $productAddCartForm
                                                <a class="ProduktAnfrageButton" href="$ProductQuestionLink">Produktanfrage</a>
                                                <!--<% _t('SilvercartProductPage.OUT_OF_STOCK') %>-->
                                        </div>
                                    </div>
                                </div>
        <% end_control %>
        <% else %>
                    <div class="silvercart-product-page-order-box <% if isPriceHigh %>HighPrice<% end_if %>" id="addCart_$variant" >
						<% if isPriceHigh %>
						<img src="/assets/Uploads/Images/style/gratisversand.png" class="yeahsilvercartkotz" alt=""/>
						<% end_if %>
						<div class="silvercart-product-page-box-price">
							<p class="silvercart-price">
								$Price.Nice
							</p>
							<small>
								<% if CurrentPage.showPricesGross %>
									<% sprintf(_t('SilvercartPage.INCLUDING_TAX', 'incl. %s%% VAT'),$TaxRate) %><br />
								<% else_if CurrentPage.showPricesNet %>
									<% _t('SilvercartPage.EXCLUDING_TAX', 'plus VAT') %><br />
								<% end_if %>
								<% control Top.PageByIdentifierCode(SilvercartShippingFeesPage) %>
									<a href="$Link" title="<% sprintf(_t('SilvercartPage.GOTO', 'go to %s page'),$Title.XML) %>">
										<% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %><br/>
									</a>
								<% end_control %>
							</small>
						</div>

						<div class="silvercart-product-availability">
                            <% if isBuyableDueToStockManagementSettings %>
                                    $StockQuantity
                            <% end_if %>
                            $Availability
						</div>

						<div class="silvercart-product-group-add-cart-form" style="">
							<div class="silvercart-product-group-add-cart-form_content 	<% if isBuyableDueToStockManagementSettings %> buy <% else %> notBuy <% end_if %>">

								    $productAddCartForm
                                    <a class="ProduktAnfrageButton" href="$ProductQuestionLink">Produktanfrage</a>
									<!--<% _t('SilvercartProductPage.OUT_OF_STOCK') %>-->
							</div>
						</div>
					</div>
<% end_if %>


                    <script type="text/javascript" >
                        jQuery(document).ready(function($) {
                            var option = $("select").val();
                            //alert(option);
                            $("#addCart_"+option).css("display", "block");
                            $("select").change(function(){
                                var option = $(this).val();
                                $("select").val(option);
                                $(".silvercart-product-page-order-box").css("display", "none");
                                $("#addCart_"+option).css("display", "block");

                            });
                        });

                    </script>