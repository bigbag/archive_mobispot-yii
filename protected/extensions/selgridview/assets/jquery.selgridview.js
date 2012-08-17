(function ($) {
    var methods,
    selGridSettings = [];

    methods = {
        init: function (options) {
            var selSettings = $.extend({
                selVar: 'sel'
            }, options || {});

            return this.each(function () {
                var $grid = $(this),
                id = $grid.attr('id'),
                beforeAjaxUpdateOrig;

                selGridSettings[id] = selSettings;

                //overloading beforeAjaxUpdate 
                var settings = $.fn.yiiGridView.settings[id];
                if(settings.beforeAjaxUpdate !== undefined) {
                    beforeAjaxUpdateOrig = settings.beforeAjaxUpdate;
                } else {
                    beforeAjaxUpdateOrig = function(id, options) {}; 
                }

                delete settings.beforeAjaxUpdate;
                settings.beforeAjaxUpdate = function(id, options) {
                    var selVar = selGridSettings[id].selVar,
                    selection = $('#' + id).selGridView('getAllSelection'),
                    params = $.deparam.querystring(options.url);

                    if(!selection) {         //if nothing selected in whole grid -> delete selVar from request
                        if(params[selVar]) delete params[selVar];
                    } else {                //otherwise set selVar to array of selected keys
                        params[selVar] = selection;
                    }                    

                    options.url = $.param.querystring(options.url, params);

                    //call user's handler
                    beforeAjaxUpdateOrig(id, options);
                }

            });
        },        

        getAllSelection: function () {
            var settings = $.fn.yiiGridView.settings[this.attr('id')],
            selVar = selGridSettings[this.attr('id')].selVar,
            url = this.yiiGridView('getUrl');

            var params = $.deparam.querystring(url);

            //rows selected by GET
            var checkedInQuery = (params[selVar]) ? params[selVar] : [];
            if(!$.isArray(checkedInQuery)) checkedInQuery = [checkedInQuery];

            //rows selected on current page
            var checkedInPage = this.yiiGridView('getSelection');

            /*
              if only one row can be selected:
                1. if selected on current page - return it
                2. if nothing selected on current page - return previous selection
            */
            if(settings.selectableRows == 1) {
                if(checkedInPage.length) {
                    return checkedInPage;
                } else {
                    return checkedInQuery;
                }
            }

            /*
            if selectableRows > 1 - merge selected on current page with selected on other pages
            We need go though all keys on current page because user could deselect some of previously selected - we should delete it
            */

            //iterating all keys of this page
            this.find(".keys span").each(function (i) {
                var key = $(this).text();

                //row found in GET params: means row was selected on page load
                var indexInQuery = $.inArray(key, checkedInQuery);

                //row is checked on current page
                var indexInChecked = $.inArray(key, checkedInPage);

                //row is selected and not in GET params --> adding to GET params
                if(indexInChecked >= 0 && indexInQuery == -1) {
                    checkedInQuery.push(key); 
                }

                //row not selected, but in GET params due to selected on page load --> deleting from GET params
                if(indexInChecked == -1 && indexInQuery >= 0) {
                    checkedInQuery.splice(indexInQuery, 1); 
                }
            });     

            return checkedInQuery;

            if(!checkedInQuery) {   //if nothing selected in whole grid -> delete "sel" variable from request
                if(params[selVar]) delete params[selVar];
            } else {                //otherwise set "sel" var to array of selected keys
                params[selVar] = checkedInQuery;
            }                    

        }
    };


    $.fn.selGridView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }else {
            $.error('Method ' + method + ' does not exist on jQuery.selGridView');
            return false;
        }
    };        

})(jQuery);