define([
    'ko',
    'jquery',
    'uiComponent',
    'tabCode'
], function(ko, $, Component, code){
    'use strict';

    let referralCode = ko.observable('');

    return Component.extend({

        /**
         *  @inheritdoc
         */
        initialize: function () {
            this._super();
            code().load(this.codeUrl);
            this.referralCode = referralCode;
        },

        /**
         * Is form loaded
         */
        visible: ko.computed(function() {
            return code().loaded();
        }),

        /**
         * Get customer code
         */
        getCode: ko.computed(function() {
            let get = code().get();
            referralCode(get);
            return get;
        }),

        /**
         * Show apply button
         */
        showApply: ko.computed(function(){
            return code().apply() || referralCode() !== code().get();
        }),

        /**
         * Apply new code action
         */
        apply: function() {
            if(!this.isValid()) return null;
            if(referralCode() !== code().get()) {
                code().applyAction(this.applyCode, referralCode());
            }else {
                code().applyAction(this.applyCode);
            }
        },

        /**
         * Generate new code action
         */
        generate: function() {
            code().generate(this.codeGenerate);
        },

        /**
         * Is valid code input
         */
        isValid: ko.computed(function() {
            if(referralCode() === code().get()) {
                return null;
            }
            let val = referralCode();
            if(val) {
                let len = val.length > 3 && val.length <= 20;
                let pattern = /^[a-zA-Z0-9]+$/ui;
                return len && val.match(pattern) !== null;
            }
            return false;
        }),

        /**
         * Input pattern
         */
        pattern: ko.computed(function(){
            let val = referralCode();
            if(val.length > 20) {
                referralCode(val.slice(0,20));
            }
        })
    });
});