define([
   'jquery',
   'ko',
   'uiComponent'
], function($, ko, Component){

    let load = ko.observable(false);
    let referrals = ko.observableArray([]);
    let ajax = false;

    return Component.extend({
        /**
         *  @inheritdoc
         */
        initialize: function () {
            this._super();
        },

        /**
         * Get referrals array
         */
        get: ko.computed(function(){
            return referrals();
        }),

        /**
         * Is items loaded
         */
        isLoaded: ko.computed(function(){
            return load();
        }),

        /**
         * Load relations
         * @param url
         * @param p
         */
        load: function(url, p = 1) {
            load(false);
            ajax ? ajax.abort() : null;
            ajax = $.ajax({
                url: url,
                dataType: 'json',
                data: {
                   'p' : p
                },
                type: 'GET'
            }).success(function(res){
                referrals(res.items);
                load(true);
            });
        }
    });
});