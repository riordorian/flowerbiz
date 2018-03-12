'use strict';

var crm = new function(){
    this.init = function()
    {
        crm.updateWindowInfo();

        crm.widgets.init();
        crm.blocks.init();
    }


    /**
     * Updating info about current window width
     */
    this.updateWindowInfo = function()
    {
        crm.isMobile = crm.isTablet = crm.isDesktop = false;

        if( $(window).width() < 768 ){
            crm.isMobile = true;
        }
        else if( $(window).width() >= 768 && $(window).width() < 1024 ){
            crm.isTablet = true;
        }
        else{
            crm.isDesktop = true;
        }
    }
}


/*
* The portal sections
* */
crm.blocks = new function()
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
* Widgets
* */
crm.widgets = new function()
{
    this.items = {};

    this.loading = '';

    var clockpicker;

    /*
    * Select customization
    * */
    this.items['chosen'] = function(selector)
    {
        if( !$.fn.chosen ){
            return;
        }
        
        $.each(selector, function() {
            var element = $(this);

            if( element.closest('.hidden').length > 0 ){
                return true;
            }

            var arConfig = $.extend(
                {},
                crm.widgets.items.chosen.defaults,
                element.data('config') || {}
            );

            console.log(arConfig);
            element.chosen(arConfig);
        });
    }

    this.items['chosen'].defaults = {
        width: '100%',
        disable_search: true
    };


    /*
    * checkboxes and radio buttons customization
    * */
    this.items['i-checks'] = function(selector)
    {
        if( !$.fn.iCheck ){
            return;
        }

        $(selector).each(function() {
            var element = $(this);

            var arConfig = $.extend(
                {},
                crm.widgets.items['i-checks'].defaults,
                element.data('config') || {}
            );

            element.iCheck(arConfig);
        });
    }

    this.items['i-checks'].defaults = {
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    };


    /*
    * datepicker widget
    * */
    this.items['datepicker'] = function(selector)
    {
        if( !$.fn.datepicker ){
            return;
        }

        $.fn.datepicker.dates['ru'] = {
            days: ["Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            daysShort: ["Пн", "Вт", "Ср", "Чтв", "Птн", "Сбб", "Вск"],
            daysMin: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сбб", "Вск"],
            months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            monthsShort: ["Янв", "Фев", "Мрт", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
            today: "Сегодня",
            clear: "Очистить",
            format: "dd.mm.yyyy",
            titleFormat: "MM yyyy",
            weekStart: 0
        };

        $(selector).each(function() {
            var element = $(this);

            var arConfig = $.extend(
                {},
                crm.widgets.items['datepicker'].defaults,
                element.data('config') || {}
            );

            element.datepicker(arConfig);
        });
    }

    this.items['datepicker'].defaults = {
        startView: 1,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: false,
        language: 'ru',
        format: "dd.mm.yyyy",
    };


    /*
     * datepicker widget
     * */
    this.items['clockpicker'] = function(selector)
    {
        if( !$.fn.clockpicker ){
            return;
        }
        
        $(selector).each(function() {
            var element = $(this);

            var arConfig = $.extend(
                {},
                crm.widgets.items['clockpicker'].defaults,
                element.data('config') || {}
            );

            clockpicker = element.clockpicker(arConfig);
        });
    }

    this.items['clockpicker'].defaults = {
        default: 'now',
        autoclose: true,
        donetext: '',
    };


    /*
     * datetimepicker widget
     * */
    this.items['datetimepicker'] = function(selector)
    {
        if( !$.fn.datetimepicker ){
            return;
        }

        $(selector).each(function() {
            var element = $(this);

            var arConfig = $.extend(
                {},
                crm.widgets.items['datetimepicker'].defaults,
                element.data('config') || {}
            );

            element.datetimepicker(arConfig);
        });
    }

    this.items['datetimepicker'].defaults = {
        locale: 'ru',
    };


    /*
     * switcher widget
     * */
    this.items['switcher'] = function(selector)
    {
        if( typeof(Switchery) !== 'function' ){
            return;
        }

        $(selector).each(function() {
            var element = this;

            var arConfig = $.extend(
                {},
                crm.widgets.items['switcher'].defaults,
                $(element).data('config') || {}
            );


            if( !$(element).siblings('.switchery').length ){
                var switcher = new Switchery(element, arConfig);
            }
        });
    }

    this.items['switcher'].defaults = {
        color: '#1AB394'
    };


    /*
     * fullcalendar widget
     * */
    this.updateFCDefaults = function()
    {
        if( $(window).width() < 768 ){
            crm.widgets.items.fullcalendar.defaults.header.left = 'prev, next';
            crm.widgets.items.fullcalendar.defaults.header.center = '';
            crm.widgets.items.fullcalendar.defaults.header.right = 'agendaWeek,agendaDay,listMonth';
            crm.widgets.items.fullcalendar.defaults.defaultView = 'listMonth';
        }


    }

    this.items['fullcalendar'] = function(selector)
    {
        if( typeof($.fn.fullCalendar) !== 'function' ){
            return;
        }

        crm.widgets.updateFCDefaults();

        $(selector).each(function() {
            var element = this;

            var arConfig = $.extend(
                {},
                crm.widgets.items.fullcalendar.defaults,
                $(element).data('config') || {}
            );

            console.log(arConfig);

            var calendar = $(element).fullCalendar(arConfig);
        });
    }


    this.items['fullcalendar'].defaults = {
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
        views: {
            week: { // name of view
                // titleFormat: "DD",
                titleRangeSeparator: " - ",
                columnFormat: "ddd DD"
            }
        },
        googleCalendarApiKey: 'AIzaSyBJT-1hsgo7LXiOlIOW_CqkBwNTna7xoZc',
        navLinks: true,
        editable: true,
        locale: 'ru',
        height: 650,
        droppable: true, // this allows things to be dropped onto the calendar
        dayClick: function (date, jsEvent, view) {
            var loading = new crm.ui.loading();
            crm.updateWindowInfo();
            jsEvent.preventDefault();

            if( crm.isDesktop ) {
                $('.terminal__calendar-wrap').addClass('active');
            }

            $.ajax({
                url: '/terminal/orders-schedule/create/',
                method: 'post',
                dataType: 'html',
                success: function(response){
                    if( $('.js-terminal__sidebar').length && crm.isDesktop ){
                        $('.js-terminal__sidebar').html(response);
                        crm.widgets.init($('.js-terminal__sidebar'));
                        terminal.blocks.findUser();
                        $('.js-terminal__sidebar').find('#dateStart, #dateEnd').val(date);
                    }
                    else if( crm.isMobile || crm.isTablet && $.fn.magnificPopup != undefined ){
                        crm.ui.openPopup(response);
                    }

                    loading.hide();
                }
            });


        },
        eventClick: function (date, jsEvent, view) {
            var loading = new crm.ui.loading();

            if( crm.isDesktop ) {
                $('.terminal__calendar-wrap').addClass('active');
            }

            $.ajax({
                url: '/terminal/orders-schedule/view/?id=' + date.id,
                method: 'post',
                dataType: 'html',
                success: function(response){
                    if( $('.js-terminal__sidebar').length && crm.isDesktop ){
                        $('.js-terminal__sidebar').html(response);
                    }
                    else if( crm.isMobile || crm.isTablet && $.fn.magnificPopup != undefined ){
                        crm.ui.openPopup(response);
                    }

                    loading.hide();
                }
            });
        },
        eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
            var loading = new crm.ui.loading();
            
            var newDate = new Date(
                event.start._i[0],
                event.start._i[1],
                event.start._i[2],
                event.start._i[3],
                event.start._i[4],
                event.start._i[5]
            );

            var month = newDate.getMonth().toString().length == 1 ? '0' + (newDate.getMonth() + 1).toString() : (newDate.getMonth() + 1).toString();
            var day = newDate.getDate().toString().length == 1 ? '0' + newDate.getDate().toString() : newDate.getDate().toString();
            var hours = newDate.getHours().toString().length == 1 ? '0' + newDate.getHours().toString() : newDate.getHours().toString();
            var minutes = newDate.getMinutes().toString().length == 1 ? '0' + newDate.getMinutes().toString() : newDate.getMinutes().toString();
            var seconds = newDate.getSeconds().toString().length == 1 ? '0' + newDate.getSeconds().toString() : newDate.getSeconds().toString();

            newDate = newDate.getFullYear() + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

            $.ajax({
               url: '/terminal/orders-schedule/change-date/?ID=' + event.id + '&START=' + newDate,
               method: 'get',
               dataType: 'json',
               success: function(response){
                   loading.hide();
                   console.log(response);
               }
            });
        },
        eventSources: [
           /* {
                googleCalendarId: 'k8jd9gfj6je95ggc2s7gubssd0@group.calendar.google.com',
                className: 'gcal-event',
                editable: false,
                backgroundColor: 'red'
            },*/
            $('.js-widget.fullcalendar').data('orders')
        ],
        eventRender: function(event, element, view) {
            if( view.name == 'month' ){
                element.find('.fc-time').hide();
            }
            if( event.hasOwnProperty('description') && $(window).width() > 767 ){
                element.find('.fc-title').append("<br/>" + event.description);
            }
            console.log(event);
            if( event.hasOwnProperty('STATUS') && event.STATUS == 'N' ){
                element.addClass('fc-event__danger');
            }
        },
    };

    this.items['popover-widget'] = function(selector){
        if( $.fn.popover == undefined || !$.fn.popover.length ){
            return;
        }

        $(selector).each(function() {
            var element = this;
            var arConfig = $.extend(
                {},
                crm.widgets.items['popover-widget'].defaults,
                $(element).data('config') || {}
            );
            arConfig['content'] = $($(this).data('popover-content')).html();
            
            var popover = $(element).popover(arConfig);
        });
    }

    this.items['popover-widget'].defaults = {
        html : true
    };


    /*
     * popup widget
     * */
    this.items['popup'] = function(selector)
    {
        if( $.fn.magnificPopup == undefined || !$.fn.magnificPopup.length ){
            return;
        }

        $(selector).each(function() {
            var element = this;

            var arConfig = $.extend(
                {},
                crm.widgets.items['popup'].defaults,
                $(element).data('config') || {}
            );

            var popup = $(element).magnificPopup(arConfig);
        });
    }

    this.items['popup'].defaults = {
        type: 'ajax',
        tLoading: '',
        closeBtnInside: false,
        callbacks: {
            ajaxContentAdded: function() {
                crm.widgets.init(this.content);
                crm.widgets.loading.hide();
            },
            beforeAppend: function() {
                crm.widgets.loading = new crm.ui.loading();
            },
            open: function(){
                crm.widgets.loading.hide();
            }

        }

    };


    this.items['uploadpicker'] = function(selector)
    {
        $(selector).each(function() {
            var field = $(this);
            console.log(field);
            var required = field.is('[required]');
            var disabled = field.is('[disabled]');
            var isMultiple = field.is('[multiple]');
            var placeholder = field.attr('placeholder');
            var maxFiles = field.data("max-files");
            if(!maxFiles)
                maxFiles = 10;

            field
                .addClass('upload-field-overlay')
                .removeAttr('required')
                .css({
                    cursor: 'pointer',
                    fontSize: '200px',
                    height: 'auto',
                    opacity: 0,
                    position: 'absolute',
                    right: 0,
                    top: '-0.5em',
                    width: 'auto',
                    zIndex: 99
                })
                .wrap('<span class="widget-upload-field"/>')

            var wrapper = field.parent();
            wrapper
                .css({
                    backgroundColor: 'transparent',
                    display: 'block',
                    overflow: 'hidden',
                    position: 'relative'
                })
                .prepend('<input class="upload-field-value form-control" type="text"'
                    + (required ? ' required=""' : '')
                    + (disabled ? ' disabled=""' : '')
                    + (placeholder ? ' placeholder="' + placeholder + '"' : '')
                    + ' />');

            var $fileAdd = wrapper.closest(".js-file-add");
            var $fileAddLabel = $fileAdd.find('.upload-field-label');
            field.on({'change': function() {
                if(isMultiple){
                    if($(this).closest(".js-new-add-container").length == 0){
                        $(this).closest(".span_file").wrap("<div class='js-new-add-container'></div>");
                    }
                    var count = selector.closest(".js-new-add-container").find(".js-file-add").length;
                    if(maxFiles < count){
                        return false;
                    }

                    $(this).closest(".js-new-add-container").append('<div class="span_file span_file--new js-file-add js-file-add--new">' +
                        '<input  name="FILE[]" type="file" multiple class="widget uploadpicker js-new-uploadpicker js-new-uploadpicker-' + count + '" data-max-files="' + maxFiles + '" placeholder="Выберите файл">' +
                        '<div class="is-label">' +
                        '<small class="block-form__delete">' +
                        '<span class="upload-field-label"><i class="js-file-reset"></i></span>' +
                        '</small>' +
                        '</div>' +
                        '</div>');

                    site.ui.widgets.items.uploadpicker($(".js-new-uploadpicker-" + count));
                    $(this)
                        .closest(".js-new-add-container")
                        .find(".js-file-add--new:not(:last-child)")
                        .find(".add-file")
                        .remove();
                }

                var values = [this.value.split(/[\/\\]/).pop()];
                if (this.files) {
                    values = [];
                    for (var i = 0; i < this.files.length; i++) {
                        values.push(this.files[i].name);
                    }
                }
                values.length ? wrapper.addClass('has-value') : wrapper.removeClass('has-value');
                wrapper.find('.upload-field-value').val(values.join(', '));
            }, 'keypress': function(event) {
                if (event.key == 'Backspace') {
                    if (this.value) {
                        event.preventDefault();
                        this.value = '';
                        $(this).trigger('change');
                    }
                }
            }
            });
        });
    };


    /**
     * Widgets initialization
     */
    this.init = function($selector)
    {
        if( $selector == undefined || !$selector.length ){
            $selector = $('body');
        }

        $.each(this.items, function(widgetName){
            this.call(this, $selector.find('.js-widget.' + widgetName));
        });
    }
}

crm.ui = new function ()
{
    var ui = this;
    ui.loading = function (selector)
    {
        var loading = this;
        loading.template = '<div class="loader-wrapper">' +
            '<div class="loader-wrapper__item"></div>' +
        '</div>';
        
        loading.show = function ()
        {
            $(loading.template).appendTo(selector);
        }

        loading.hide = function()
        {
            $(selector)
                .find('.loader-wrapper')
                .remove();
        }

        if( selector == undefined && !$(selector).length ){
            selector = 'body';
        }

        loading.show(selector);
    }

    /**
     * Opening content in popup
     */
    ui.openPopup = function(content)
    {
        if( $.magnificPopup == undefined ){
            return false;
        }

        $.magnificPopup.close();
        $.magnificPopup.open({
            items: {
                src: content
            },
            type: 'inline',
            callbacks: {
                open: function(){
                    crm.widgets.init(this.content);
                }
            }
        }, 0);
    }


    ui.numberFormat = function(number, decimals, decPoint, thousandsSep)
    {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousandsSep === 'undefined') ? '`' : thousandsSep,
            dec = (typeof decPoint === 'undefined') ? '.' : decPoint,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };

        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }

        return s.join(dec);
    }
}

$(document).ready(function() {
    crm.init();
});