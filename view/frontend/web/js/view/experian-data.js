define([
    'jquery',
    'uiComponent',
    'Magepow_OnestepCheckout/js/view/experian-data-services',
    'Magento_Checkout/js/checkout-data' ,
    'uiRegistry',
    'mage/url',
    'uiClass'
], function (
    $,
    Component,
    ExperianDataServices,
    checkoutData,
    uiRegistry,
    url,
    uiClass

) {

    setTimeout(function () {

        var apiKey =  window.checkoutConfig.mageConfig.experian_api_key;
        var countryDomID    = uiRegistry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.country_id').uid;
        var cityDomID       = uiRegistry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.city').uid;
        var postcodeDomID   = uiRegistry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.postcode').uid;
        var regionDomId     = uiRegistry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.region_id').uid;
        var search_input = document.querySelector("input[name='street[0]']");
        var countryMap = {"AU":"AUS;DataFusion","US": "USA"};
        var options = {
            token: apiKey,
            elements: {
                input: search_input,
                countryList: document.querySelector('#'+countryDomID),
                countryCodeMapping : countryMap,
                addressLine1: document.querySelector("input[name='street[0]']"),
                addressLine2: document.querySelector("input[name='street[0]']"),
                addressLine3: document.querySelector("input[name='street[0]']"),
                locality:     document.querySelector("input[name='street[0]']"),
                province:     document.querySelector("input[name='street[0]']"),
                postalCode:   document.querySelector("input[name='street[0]']")
            }
        };
        var address = window.ContactDataServices.address(options);
        $(document).on('click','.address-picklist-container .address-picklist div' ,function() {
            var text        = $(this).text();
            let fillCity   = text.split(/[\s,]+/);
            let cityEAV    = fillCity[fillCity.length -3];
            let regionEAV  = fillCity[fillCity.length -2];
            let fillcode   = fillCity[fillCity.length -1];
            $('#'+cityDomID).val(cityEAV);
            $('#'+cityDomID).trigger('change');
            $('#'+postcodeDomID).val(fillcode);
            $('#'+postcodeDomID).trigger('change');
            var country = $('#'+countryDomID).val();
            var getUrl = url.build('onestepcheckout/experian/region');
            $.ajax({
                url: getUrl,
                type: "POST",
                data: {country : country, region: regionEAV},
                showLoader: true,
                cache: false,
                dataType: 'json',
                success: function(data){
                    var regionId = data[regionEAV];
                    $("select[name='region_id'] option[value='"+regionId+"']").attr('selected', true);
                    $('#'+regionDomId).trigger('change');
                }
            });

        })

    }, 7000);

    return Component;

});
