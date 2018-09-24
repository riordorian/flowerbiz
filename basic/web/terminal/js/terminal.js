'use strict';

var terminal = new function() {
    var orderSum;

    this.init = function () {
        terminal.blocks.init();
    }

    /*
    * discount - % of discount
    * bonus - group % bonus
    * maxDiscount - max discount %
    * clientBonus - client bonuses
    * */
    this.calcSum = function (discount, bonus, maxDiscount, clientBonus) {
        // order sum
        orderSum = 0;
        var $sumField = $('.js-sum');
        var $workPaymentField = $('[name=WORK_PAYMENT]');
        var $sumText = $('.js-sum').prev().find('span');
        var $cartInfoText = $('.js-cart-mobile-info');
        var $bonusField = $('.js-bonus');
        var $clientBonusField = $('.js-client-bonus');
        var $clientBonusText = $('.js-client-bonus').prev().find('span');
        var $clientBonusLimitField = $('.js-bonus-limit');
        var $saleBonusLimitField = $('.js-sale-bonus-limit');
        var $saleBonusField = $('.js-sale-bonus');
        var $clientBonusLimitText = $('.js-bonus-limit').prev().find('span');
        var $discountField = $('.js-discount');
        var $finalSumField = $('.js-final-sum');
        var operatorPercent = parseInt($('.js-operator-percent').val());

        $('.js-cart-good input[type=text]:visible').each(function () {
            orderSum += parseInt($(this).val()) * parseInt($(this).closest('.js-cart-good').data('price'));
        });

        // Operators work
        if (operatorPercent > 0 && !$('.js-cart-bouquet:visible').length && $workPaymentField.is(':checked')) {
            orderSum += orderSum * operatorPercent / 100
        }

        $sumField.val(orderSum);
        $sumText.text(crm.ui.numberFormat(orderSum, 0, '.', ' '));
        $cartInfoText.text(crm.ui.numberFormat(orderSum, 0, '.', ' '));

        var discountVal = parseInt(parseInt($sumField.val()) * parseInt(discount) / 100);
        if (isNaN(discountVal)) {
            discountVal = 0;
        }

        var total = orderSum - discountVal;
        maxDiscount = parseInt(maxDiscount);
        clientBonus = parseInt(clientBonus);
        var maxBonusVal = parseInt(total * maxDiscount / 100);
        maxBonusVal = maxBonusVal > clientBonus ? clientBonus : maxBonusVal;
        var bonusForOrder = parseInt(bonus / 100 * total);

        $bonusField.val(bonus).prev().find('span').text(crm.ui.numberFormat(bonusForOrder, 0, '.', ' '));
        $saleBonusField.val(bonusForOrder)
        $clientBonusField.val(clientBonus);
        $clientBonusText.text(crm.ui.numberFormat(clientBonus, 0, '.', ' '));

        $clientBonusLimitField.val(maxDiscount);
        $saleBonusLimitField.val(maxBonusVal);
        $clientBonusLimitText.text(crm.ui.numberFormat(maxBonusVal, 0, '.', ' '));

        $discountField.val(discount > 0 ? discount : 0);
        if (discountVal > 0) {
            $discountField
                .prev()
                .find('span')
                .text(crm.ui.numberFormat(discountVal, 0, '.', ' '));

            $bonusField.val(0).prev().find('span').text(0);
        }
        else {
            $discountField.prev().find('span').text(0);
        }

        $finalSumField.val(total).prev().find('span').text(crm.ui.numberFormat(total, 0, '.', ' '));
    }
}

/*
 * The terminal sections
 * */
terminal.blocks = new function()
{
    this.init = function ()
    {
        var constructor;

        for(var key in this){
            constructor = this[key];
            var bBlockExists = constructor.exists ? constructor.exists() : true;
            if( bBlockExists ){
                this.key = new constructor();
            }
        }
    }
}


/*
* Finding user by phone or name
* */
terminal.blocks.findUser = function(query, process)
{
    var initElem = '.js-autocomplete-user';

    this.init = function()
    {
        var loading = crm.ui.loading(initElem);
        var settings = {
            source: function (query, process) {
                return $.post(
                    '/terminal/clients-list/',
                    { QUERY: query },
                    function (data) {
                        var arClients = [];

                        $.each(data, function(i, arItem){
                            arClients.push(
                                {
                                    ID : arItem['ID'],
                                    NAME: arItem['NAME'],
                                    SEARCH_NAME: arItem['NAME'] + ' &ndash; <b>' + arItem['PHONE'] + '</b>',
                                    PHONE: arItem['PHONE']
                                });
                        });

                        return process(arClients);
                    }, 'json');
            },
            /*
             * Check that item satisfies condition
             * */
            matcher: function (arItem) {
                var requestedPhone;
                var name = arItem['SEARCH_NAME'].toUpperCase();

                if( parseInt(this.query) > 0 && this.query.length == 4 ){
                    requestedPhone = this.query.substring(0, 2) + '-' + this.query.substring(2, 2);
                }

                if (
                    arItem.hasOwnProperty('PHONE') && arItem.PHONE.indexOf(requestedPhone) !== -1
                    || name.indexOf(this.query.toUpperCase()) != -1
                ) {
                    return arItem.SEARCH_NAME;
                }
            },
            displayText: function (arItem) {
                return arItem.SEARCH_NAME;
            },
            updater: function (arItem) {
                $('.js-client-id-field').val(arItem.ID);
                updateUserInfo(arItem.ID)

                return arItem.NAME;
            },
            minLength: 3
        };

        var obInstance = $(initElem).typeahead(settings);

        /**
         * If collecting pre order
         */
        if( $('.js-client-id-field').length && $('.js-client-id-field').val() > 0 ){
            updateUserInfo($('.js-client-id-field').val(), true); 
        }
    }


    /**
     * Updating info about User
     */
    var updateUserInfo = function(userId, bUpdateInput)
    {
        if( userId == undefined || isNaN(userId) || userId == 0 ){
            return false;
        }

        $.ajax({
            url: '/terminal/orders/get-user-discounts/',
            method: 'post',
            dataType: 'json',
            data: [{
                name: 'USER_ID',
                value: userId,
            }],
            success: function (response) {
                var discount = response.hasOwnProperty('DISCOUNT') ? response.DISCOUNT : 0;
                var bonus = response.hasOwnProperty('BONUS') ? response['BONUS'] : 0;
                var clientBonus = response.hasOwnProperty('CLIENT_BONUS') ? response['CLIENT_BONUS'] : 0;
                var maxDiscount = response.hasOwnProperty('MAX_DISCOUNT') ? response['MAX_DISCOUNT'] : 0;
                $('.js-sale-link').removeClass('disabled');

                terminal.calcSum(
                    discount,
                    bonus,
                    maxDiscount,
                    clientBonus
                );

                if( bUpdateInput ){
                    $('.js-autocomplete-user').val(response['USER_NAME']);
                }
            }
        });
    }

    this.init();
}


/**
 * Updating goods block
 */
terminal.blocks.updateGoods = function()
{
    var goods = this;
    var categoryItem = '.js-category-item';
    var allGoods = '.js-all-goods';
    var url = '';
    var timeOut;

    $(document).on('click', categoryItem, function(){
        var categoryId = $(this).data('category-id');
        url = '/terminal/orders/goods-list/?categoryId=' + categoryId;

        goods.update(url);
    });

    $(document).on('click', allGoods, function(){
        url = '/terminal/orders/sections-list/';
        goods.update(url);
    });

    $(document).on('keyup', '.js-find-goods', function () {
        url = '/terminal/orders/goods-list/?name=' + $('.js-find-goods').val();
        clearTimeout(timeOut);
        timeOut = setTimeout(function(){
            goods.update(url)
        }, 1000);
    });

    this.update = function(url)
    {
        var loading = new crm.ui.loading();

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response){
                $('.js-goods-wrap').html(response);
                loading.hide();
            }
        });


    }
}
terminal.blocks.updateGoods.exists = function(){
    return $('.js-goods-wrap').length;
}


/**
 * Adding good to cart
 */
terminal.blocks.addGood2Cart = function()
{
    var add2Cart = this;
    var cart = '.js-cart';
    var orderSum,
        orderTotal,
        timeOut;
    
    $(document).on('click', '.js-good-item', function(e){
        e.preventDefault();

        if( $('.js-cart-bouquet:visible').length ){
            crm.ui.openPopup('<div class="alert alert-danger">Невозможно одновременно добавить в корзину букет и товар</div>');
            return false;
        }
        add2Cart.add($(this).data('good-id'));
    });

    $(document).on('keyup', '.js-cart-good input', function(e){
        e.preventDefault();
        var $input = $(this);
        clearTimeout(timeOut);
        timeOut = setTimeout(function(){
            add2Cart.add($input.closest('.js-cart-good').data('good-id'), $input.val());
        }, 1000);
    });


    add2Cart.add = function(goodId, count)
    {
        var loading = new crm.ui.loading();
        var $cartGood = $(cart).find('[data-good-id=' + goodId + ']');

        $.ajax({
            url: '/terminal/orders/update-info/?goodId=' + goodId,
            method: 'post',
            dataType: 'json',
            success: function(response){
                if( response.hasOwnProperty('AMOUNT') && response.AMOUNT > 0 ){
                    var goodPrice = parseInt(response['RETAIL_PRICE']);

                    if( !$('.js-cart .js-cart-bouquet:visible').length ){
                        $('.js-bouquet').removeClass('hidden');
                    }
                    else{
                        $('.js-bouquet').addClass('hidden');
                    }


                    // Updating good info
                    if( $cartGood.length && $cartGood.find('input').val() < parseInt(response.AMOUNT) ){
                        $cartGood.find('input').val(count == undefined ? parseInt($cartGood.find('input').val()) + 1 : parseInt(count));
                    }
                    else if( $cartGood.length ){
                        var $alertWrap = $('<div/>');
                        $('<div/>', {
                            'class': 'white-bg p-sm col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12',
                            'html': '<h3>На складе недостаточно товара</h3>'
                        }).appendTo($alertWrap);
                        crm.ui.openPopup($alertWrap.html());
                        $cartGood.find('input').val(response.AMOUNT);
                    }
                    else{
                        // Adding good to cart
                        var $good = $(cart).find('.js-cart-good-template').clone(false);
                        $good
                            .attr('data-good-id', goodId)
                            .attr('data-price', goodPrice)

                            .find('input')
                            .attr('name', 'CatalogProducts[' + goodId + ']')

                            .end()
                            .find('img')
                            .attr('src', response.IMAGE)
                            
                            .end()
                            .find('p').eq(0)
                            .html($good.find('p').eq(0).html().replace('#NAME#', response.NAME))
                            
                            .end()
                            .end()
                            .find('p').eq(1)
                            .html($good.find('p').eq(1).html().replace('#PRICE#', crm.ui.numberFormat(goodPrice, 0, '.', ' ')))
                            
                            .end()
                            .end()
                            .appendTo($('.js-terminal__cart-goods'))
                            .removeClass('hidden js-cart-good-template');

                        $('.js-terminal__cart-goods').removeClass('hidden');
                    }

                    // Updating order info
                    // TODO: Переделать метод обновления ифнормации по заказу, т.к. он был перенесен и унифицирован
                    console.log($('.js-discount').val());
                    terminal.calcSum($('.js-discount').val(), $('.js-bonus').val(), $('.js-bonus-limit').val(), $('.js-client-bonus').val());
                    // $sum.text(crm.ui.numberFormat(orderSum, 0, '.', ' '));
                    // $('.js-sum').val(orderSum);
                }

                loading.hide();
            }
        });
    }
}
terminal.blocks.addGood2Cart.exists = function()
{
    return $('.js-cart').length > 0;
}


/**
 * Adding bouquet to cart
 */
terminal.blocks.addBouquet2Cart = function()
{
    var addBouquet2Cart = this;
    $(document).on('click', '.js-bouquet-item', function(e){
        e.preventDefault();
        if( $(e.target).hasClass('js-bouquet-delete') ){
            return false;
        }

        var $bouquet = $(this)
        var bouquetId = $(this).data('good-id');
        if( $('.js-cart-good[data-good-id=' + bouquetId + ']').length ){
            return false;
        }

        if( $('.js-cart-good:not(.js-cart-bouquet):visible').length ){
            crm.ui.openPopup('<div class="alert alert-danger">Невозможно одновременно добавить в корзину букет и товар</div>');
            return false;
        }

        $('.js-bouquet').addClass('hidden');

        var $bouquetTpl = $('.js-cart').find('.js-cart-bouquet-template').clone(false);
        $bouquetTpl
            .end()
            .find('img')
            .attr('src', $bouquet.find('.js-product-image').attr('src'))

            .end()
            .find('p').eq(0)
            .html($bouquetTpl.find('p').eq(0).html()
                .replace('#NAME#', $bouquet.find('.js-product-name').html())
                .replace('#ORDER_ID#', bouquetId)
            )

            .end()
            .end()
            .find('p').eq(1)
            .html($bouquetTpl.find('p').eq(1).html().replace('#PRICE#', crm.ui.numberFormat(parseInt($bouquet.data('price')), 0, '.', ' ')))

            .end()
            .end()
            .appendTo($('.js-terminal__cart-goods'))
            .removeClass('hidden js-cart-bouquet-template')

            .attr('data-good-id', bouquetId)
            .attr('data-price', $bouquet.data('price'));
        
        $('<input/>',{
            type: 'hidden',
            class: 'js-order',
            name: 'ORDER_ID',
            value: bouquetId
        }).appendTo($('.js-terminal__cart-goods'));

        $('.js-terminal__cart-goods').removeClass('hidden');

        terminal.calcSum($('.js-discount').val(), $('.js-bonus').val(), $('.js-bonus-limit').val(), $('.js-client-bonus').val());
    });
}
terminal.blocks.addBouquet2Cart.exists = function()
{
    return $('.js-cart').length > 0;
}


/**
 * Removing good from cart  
 */
terminal.blocks.removeFromCart = function(){
    $(document).on('click', '.js-remove-good', function(e){
        e.preventDefault();
        $(this).closest('.js-cart-good').remove();

        if( $('.js-cart-good:visible').length && !$('.js-cart-bouquet:visible').length ){
            $('.js-bouquet').removeClass('hidden')
        }
        else if( !$('.js-cart-good:visible').length ){
            $('.js-bouquet').addClass('hidden')
        }
        terminal.calcSum($('.js-discount').val(), $('.js-bonus').val(), $('.js-bonus-limit').val(), $('.js-client-bonus').val());

        if( $('.js-order').length ){
            $('.js-order').remove();
        }
    });
}
terminal.blocks.removeFromCart.exists = function(){
    return $('.js-cart').length > 0;
}


/**
 * Recalculating order sum
 */
terminal.blocks.recalcSum = function()
{
    $(document).on('change', '[name=WORK_PAYMENT]', function () {
        terminal.calcSum($('.js-discount').val(), $('.js-bonus').val(), $('.js-bonus-limit').val(), $('.js-client-bonus').val());
        $('.js-operator-work-field').val($(this).is(':checked') ? 1 : 0);
    })
}


/**
 * Sale closing popup 
 */
terminal.blocks.openSaleForm = function()
{
    var saleForm = this;

    $(document).on('click', '.js-sale-link', function(e){
        e.preventDefault();
        if( $(this).hasClass('disabled') ){
            return false;
        }
        var loading = new crm.ui.loading();
        var $link = $(this);
        var url = $link.data('href');
        var data = $link.closest('form').serializeArray();

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'html',
            data: data,
            success: function(response) {
                if( crm.isMobile || crm.isTablet || $link.data('open-type') == 'popup' ){
                    crm.ui.openPopup(response);
                }
                else if( $('.js-terminal__sidebar').length && crm.isDesktop ){
                    $('.js-terminal__sidebar').html(response);
                    crm.widgets.init($('.js-terminal__sidebar'));
                    terminal.blocks.findUser();
                }

                loading.hide();
            }
        });
    });


    // Sale change calculation
    this.calcChange = function($elem)
    {
        var $saleFormWrap = $elem.closest('.js-sale-form-wrap');
        var $changeBlock = $('.js-change');
        var $sert = $('input[name=SERT]');

        var orderSum = parseInt($saleFormWrap.data('sum'));
        var fieldsSum = 0;
        var sertVal = $sert.val() == '' || $sert.val() == undefined ? 0 : parseInt($sert.val());

        $saleFormWrap.find('input[type=number]').each(function(){
            fieldsSum += ($(this).val() == '' ? 0 : parseInt($(this).val()));
        });

        if( fieldsSum > orderSum && sertVal < orderSum ){
            $changeBlock.find('span').text(crm.ui.numberFormat(fieldsSum - orderSum, 0, '.', ' '));
        }
        else{
            $changeBlock.find('span').text(0);
        }

        if( sertVal >= orderSum || fieldsSum >= orderSum ){
            $saleFormWrap.find('.js-save-entity').removeAttr('disabled');
        }
        else{
            $saleFormWrap.find('.js-save-entity').attr('disabled', 'disabled')
        }
    }

    $(document).on('keyup', 'input[type=number]', function (e) {
        saleForm.calcChange($(this));
    });

    $(document).on('change', 'input[type=number]', function (e) {
        saleForm.calcChange($(this));
    });
}


/**
 * Saving form 
 */
terminal.blocks.saveEntity = function()
{
    var btn = '.js-save-entity';
    var obData,
        formsLength,
        loading,
        $formResult;


    /*Ajax submitting some entity form*/
    $(document).on('click', btn, function (e) {
        e.preventDefault();
        if( $(this).attr('disabled') == 'disabled' ){
            return false;
        }

        var $link = $(this);
        var $form = $link.closest('form');
        var dataType = $link.data('data-type') != undefined ? $link.data('data-type') : 'html';
        loading = new crm.ui.loading();

        formsLength = $form.length;
        if( !formsLength ){
            return false;
        }


        obData = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            dataType: dataType,
            contentType: false,
            processData: false,
            data: obData,
            success: function(response)
            {

                $formResult = $('<div>' + response + '</div>').find('#' + $form.attr('id'));
                if( $form.hasClass('js-ajax-replaceable') && $formResult.length ){
                    
                    crm.widgets.init($formResult)
                    $form.replaceWith($formResult);
                }
                else{
                    crm.ui.openPopup('<div class="white-bg col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 p-sm">Запрос уcпешно выполнен</div>');
                }


                // Error section
                if( response.STATUS === false && response.ERROR_MESSAGE.length ){
                    console.log(response.ERROR_MESSAGE);
                }

                loading.hide();
                if( $link.data('reload') == true ){
                    setTimeout(function(){
                       window.location.reload();
                    }, 1500);
                }
            }
        });

    });
}




/*
 * Adding order event
 * */
terminal.blocks.addOrderEvent = function()
{
    var btn = '.js-add-order';
    var $form,
        obData,
        loading,
        $formResult;


    /*Ajax submitting some entity form*/
    $(document).on('click', btn, function (e) {
        e.preventDefault();

        var dataType = $(this).data('data-type') != undefined ? $(this).data('data-type') : 'html';
        loading = new crm.ui.loading();

        $form = $(btn).closest('form');

        var timeStart = $form.find('.js-order-timeStart').val();
        var timeEnd = $form.find('.js-order-timeEnd').val();
        var eventTitle = $form.find('.js-order-name').val();
        var orderDate = $form.find('.js-order-date').val();
        var bInsert = $(btn).data('insert') == 1;

        obData = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            dataType: dataType,
            contentType: false,
            processData: false,
            data: obData,
            success: function(response)
            {
                var response = '<div>' + response + '</div>';
                if( $form.closest('.js-ajax-replaceable').length ){
                    $formResult = $(response).find('.js-ajax-replaceable');
                    crm.widgets.init($formResult)
                    $('.js-terminal__sidebar').html($formResult);
                }

                var newEvent = {
                    title: eventTitle,
                };
                
                var obDate = new Date(orderDate);
                if( timeStart != '' ){
                    var arStartTime = timeStart.split(':');
                    obDate.setHours(parseInt(arStartTime[0]));
                    obDate.setMinutes(parseInt(arStartTime[1]));
                }
                else{
                    obDate.setHours(0);
                    obDate.setMinutes(0);
                }
                newEvent.start = obDate;

                if( timeEnd != '' ){
                    var arEndTime = timeEnd.split(':');
                    obDate.setHours(parseInt(arEndTime[0]));
                    obDate.setMinutes(parseInt(arEndTime[1]));
                }
                else{
                    obDate.setHours(0);
                    obDate.setMinutes(0);
                }
                newEvent.end = obDate;

                // Event id
                
                if( $(response).find('.js-event-view').length && $(response).find('.js-event-view').data('id') > 0 ){
                    newEvent.id = $(response).find('.js-event-view').data('id');
                }

                if( bInsert ){
                    // TODO: Не работает добавление из-за дат
                    $('#calendar').fullCalendar( 'renderEvent', newEvent , 'stick');
                }

                loading.hide();

                // Error section
                if( response.STATUS === false && response.ERROR_MESSAGE.length ){
                    console.log(response.ERROR_MESSAGE);
                }
            }
            });

    });
}


/*
 * Adding order event
 * */
terminal.blocks.openOrderEditForm = function()
{
    $(document).on('click', '.js-open-edit-form, .js-ajax-link', function(e){
        e.preventDefault();
        var loading = new crm.ui.loading();
        var $link = $(this);
        var url = $link.data('href') != undefined ? $link.data('href') : $link.attr('href');
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'html',
            success: function(response) {
                if( crm.isMobile || crm.isTablet || $link.data('open-type') == 'popup' ){
                    crm.ui.openPopup(response);
                }
                else if( $('.js-terminal__sidebar').length && crm.isDesktop ){
                    $('.js-terminal__sidebar').html(response);
                    crm.widgets.init($('.js-terminal__sidebar'));
                    terminal.blocks.findUser();
                }
                
                loading.hide();
            }
        });
    });
}
terminal.blocks.openOrderEditForm.exists = function()
{
    return $('.js-widget.fullcalendar').length;
}

/*
 * Adding order event
 * */
terminal.blocks.scrollToElem = function()
{
    $(document).on('click', '.js-scroll-link', function(e){
        e.preventDefault();
        var target = $(this).data('href');
        if( target == undefined || !$(target).length ){
            return false;
        }

        $('html, body').animate({
            scrollTop: $(target).offset().top - 50
        }, 500);
    });
}




/*
 * Ajax query
 * TODO: Дублирующий скрипт
 * */
crm.blocks.ajaxLink = function()
{
    var loading;
    var link =  '.js-ajax-link';
    var ajax = this;

    $(document).on('click', link, function (e) {
        loading = new crm.ui.loading();
        var $link = $(this);
        e.preventDefault();

        $.ajax({
            url: $link.attr('href'),
            method: 'GET',
            dataType: $link.data('data-type') != undefined ? $link.data('data-type') : 'json',
            success: function(response){
                if( response.hasOwnProperty('STATUS')
                    && response.STATUS === true
                    && response.hasOwnProperty('CALLBACK')
                    && ajax[response.CALLBACK].length
                ){
                    ajax[response.CALLBACK]($link);
                }
                else if( $link.data('open-type') == 'popup' ){
                    crm.ui.openPopup(response);
                }
                else{
                    location.reload();
                }

                loading.hide();
            }
        });
    });


    /**
     * Deleting bouquet from goods list
     */
    ajax.deleteBouquet = function ($link)
    {
        $link.closest('.terminal__good').remove();
        if( $('.js-cart-bouquet[data-good-id=' + $link.closest('.js-bouquet-item').data('good-id') + ']').length ){
            window.location.reload();
        }
    }


    /**
     * Closing cash period
     */
    ajax.closeCashperiod = function ($link) {
        window.location.reload();
    }
}




$(function(){
   terminal.init();
});
