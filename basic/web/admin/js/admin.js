'use strict';

crm.blocks.initDOM = function(){

    // Disable negative values
    $(document).on('keyup', 'input[type=number]', function(e){
        if( $(this).attr('min') != undefined && parseInt($(this).val()) < $(this).attr('min') ){
            $(this).val($(this).attr('min'));
        }
    });
}

/*
* Reload container by changing some elem
* */
crm.blocks.reloadContainer = function()
{
    var reloadElems = '.js-reload-elems';
    var replaceableContainer = '.js-replaceable-container';
    var reloadContainer = this;

    this.make = function($elem)
    {
        var loading = new crm.ui.loading();
        var $form = $elem.closest(reloadElems).find('form');
        var data = $form.serializeArray();
        data.push({'name': 'RELOADED', 'value': 1});
        
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: data,
            dataType: 'html',
            success: function(response)
            {
                var $response = $('<div>' + response + '</div>');
                $(replaceableContainer).replaceWith($response.find(replaceableContainer));
                crm.widgets.init($(replaceableContainer));

                loading.hide();
            }
        });
    }

    $(document).on('change', reloadElems + ' .js-reload-field,' + reloadElems + ' .js-reload-field select', function(e){
        e.preventDefault();
        reloadContainer.make($(this));
    });

    $(document).on('ifChecked', '.i-checks', function(event){
        reloadContainer.make($(this));
    });

    $(document).on('keyup', reloadElems + ' .js-reload-field[type=text]', function(e){
        e.preventDefault($(this));

        var key = e.keyCode;
        if( $(this).val().length >= 2 || $(this).val().length == 0 && $.inArray(key, [16, 17, 18, 91, 93]) < 0 ){
            reloadContainer.make($(this));
        }
    });
}
/*crm.blocks.reloadContainer.exists = function ()
{
    return $('.js-reload-elems').length && $('.js-replaceable-container').length;
}*/


/*
* Adding form submit btn to page header
* */
crm.blocks.cloneBtn2Header = function()
{
    var btn = '.js-btn_cloning';
    var $form,
        obData,
        formsLength,
        loading,
        $formResult;

    if( !$('.js-page-heading__additional').find(btn).length ){
        $(btn)
            .eq(0)
            .clone(true)
            .appendTo('.js-page-heading__additional')
            .addClass('m-t-lg');
    }

    
    /*Ajax submitting some entity form*/
    $(document).on('click', btn, function (e) {
        e.preventDefault();

        var dataType = $(this).data('data-type') != undefined ? $(this).data('data-type') : 'html';
        loading = new crm.ui.loading();

        if( $('.mfp-content').length ){
            $form = $('.mfp-content').find('form');
        }
        else if( $('.tab-pane.active form:visible').length ){
            $form = $('.tab-pane.active form:visible');
        }
        else{
            $form = $('form:visible');
        }

        formsLength = $form.length;
        if( !formsLength ){
            return false;
        }

        // TODO: Слабое место для большого кол-ва записей. Например при наличии 100 событий у клиента
        $.each($form, function(index, singleForm){
            obData = new FormData($(singleForm)[0]);
            $.ajax({
                url: $(singleForm).attr('action'),
                method: $(singleForm).attr('method'),
                dataType: dataType,
                contentType: false,
                processData: false,
                data: obData,
                success: function(response)
                {
                    if( $form.hasClass('js-ajax-replaceable') ){
                        $formResult = $('<div>' + response + '</div>').find('#' + $form.attr('id'));
                        crm.widgets.init($formResult)
                        $form.replaceWith($formResult);
                    }
                    if( index == formsLength - 1 ){
                        loading.hide();
                    }

                    // Error section
                    if( response.STATUS === false && response.ERROR_MESSAGE.length ){
                        console.log(response.ERROR_MESSAGE);
                    }
                }
            });
        });

    });
}


/*
* Fixing page header on pages with forms
* */
crm.blocks.fixedHeader = function()
{
    var heading = '.js-page-heading';
    var headingOffset = $(heading).offset().top;
    var headingWidth = $(heading).outerWidth();

    $(window).scroll(function(e){
       if( $(this).scrollTop() >= headingOffset && !$(heading).hasClass('page-heading_fixed') ){
           $(heading)
               .addClass('page-heading_fixed')
               .css({
                   width: headingWidth,
               });

           $('<div>', {
               class: 'page-heading_clone',
           }).insertBefore(heading).css({height: $(heading).outerHeight()});
       }
        else if( $(this).scrollTop() < headingOffset ){
           $(heading)
               .removeClass('page-heading_fixed')
               .parent()
               .find('.page-heading_clone')
               .remove();
       }
    });
}
crm.blocks.fixedHeader.exists = function ()
{
    return $('.js-page-heading').data('fix-heading') === true;
}


/*
 * Cloning some DOM element
 * */
crm.blocks.cloneElem = function()
{
    var loading;
    var link =  '.js-link_clone';
    var $clonedElem;

    $(document).on('click', link, function (e) {
        loading = new crm.ui.loading();
        var index = $(this).index(link);
        $clonedElem = $($(this).data('cloned')).eq(index);

        if( $(this).data('cloned') == undefined || !$clonedElem.length ){
            loading.hide();
            return false;
        }

        // if( $(this).data('target') == undefined ){
            var $newElem = $clonedElem.clone(false);
            $newElem.insertBefore($(this)).removeClass('hidden').removeClass('js-form_cloned');
            crm.widgets.init($newElem);
            loading.hide();
        // }
    });
}
crm.blocks.cloneElem.exists = function ()
{
    return $('.js-link_clone').length;
}


/*
 * Delete model row
 * */
crm.blocks.deleteRow = function()
{
    var loading;
    var link =  '.js-link_del';
    $(document).find(link).each(function(){
        $(this)
            .data('href', $(this).attr('href'))
            .attr('href', 'javascript:;');
    });

    $(document).on('click', link, function (e) {
        e.preventDefault();
        var $link = $(this);
        loading = new crm.ui.loading();

        $.ajax({
            url: $link.data('href'),
            method: 'GET',
            data: {id: $(this).data('row-id')},
            dataType: 'json',
            success: function(response){
                loading.hide();
                if( response.STATUS == 'SUCCESS' ){
                    $link.closest('form').remove();
                }
            }
        });
    });
}
crm.blocks.deleteRow.exists = function ()
{
    return $('.js-link_del').length;
}

/*
 * Ajax query
 * */
crm.blocks.ajaxLink = function()
{
    var loading;
    var link =  '.js-ajax-link';
    var ajax = this;

    /*$.each($(link), function(){
        $(this)
            .data('href', $(this).attr('href'))
            .attr('href', 'javascript:;');
    });*/

    $(document).on('click', link, function (e) {
        loading = new crm.ui.loading();
        var $link = $(this);
        var dataType = $link.data('data-type') != undefined ? $link.data('data-type') : 'json';
        e.preventDefault();

        $.ajax({
            url: $link.attr('href'),
            method: 'GET',
            dataType: dataType,
            success: function(response){
                if( (crm.isMobile || crm.isTablet || $link.data('open-type') == 'popup') && dataType == 'html' ){
                    crm.ui.openPopup(response);
                }
                else if( response.hasOwnProperty('STATUS')
                    && response.STATUS === true
                    && response.hasOwnProperty('CALLBACK')
                    && ajax[response.CALLBACK].length
                ){
                    ajax[response.CALLBACK]($link);
                }
                else{
                    location.reload();
                }

                loading.hide();
            }
        });
    });

    ajax.closeCashperiod = function ($link)
    {
        $('[data-cashbox-id=' + $link.closest('.cash-period').data('cashbox-id') + ']')
            .find('i.fa-unlock')
            .removeClass('fa-unlock')
            .addClass('fa-lock')
            .end()
            .find('.js-ajax-link')
            .hide();
    }
}
crm.blocks.ajaxLink.exists = function ()
{
    return $('.js-ajax-link').length;
}