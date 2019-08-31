define([
    'ko',
    'jquery',
    'uiComponent'
], function(ko, $, Component){
    'use strict';

    let loader = false;
    let generate = false;
    let applyAction = false;
    let value = ko.observable('');
    let apply = ko.observable(false);
    let loaded = ko.observable(false);

    return Component.extend({

        /**
         *  @inheritdoc
         */
        initialize: function () {
            this._super();
        },

        /**
         * Get code value
         */
        get: ko.computed(function(){
            return value();
        }),

        set: function(code) {
            value(code);
        },

        /**
         * Is code loaded
         */
        loaded: ko.computed(function(){
           return loaded();
        }),

        /**
         * Apply new code value
         */
        apply: ko.computed(function(){
            return apply();
        }),

        /**
         * Apply generated code
         * @param url
         * @param code
         * @returns {exports}
         */
        applyAction: function(url, code = false) {
            applyAction ? applyAction.abort() : null;
            code ? value(code) : null;
            loaded(false);
            applyAction = $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                data: {
                    'code' : value()
                }
            }).success(function(res){
                apply(false);
                loaded(true);
            });
            return this;
        },

        /**
         * Generate new code
         * @param url
         * @returns {exports}
         */
        generate: function(url) {
            loaded(false);
            generate ? generate.abort() : null;
            generate = $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST'
            }).success(function(res){
                value(res.code);
                res.code ? apply(true) : null;
                loaded(true);
            });
            return this;
        },

        /**
         * Loading customer's referral code via ajax
         * @param url
         * @return self;
         */
        load: function(url) {
            loader ? loader.abort() : null;
            loader = $.ajax({
                url: url,
                dataType: 'json',
                type: 'GET'
            }).success(function(res){
                value(res.code);
                !loaded() ? loaded(true) : null;
            });
            return this;
        }

    });
});