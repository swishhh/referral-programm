define([
    'ko',
    'jquery',
    'uiComponent',
    'tabCode',
    'relations'
], function(ko, $, Component, code, relations){
    'use strict';

    let referralCode = ko.observable('');
    let flag = ko.observable('');

    return Component.extend({

        /**
         *  @inheritdoc
         */
        initialize: function () {
            this._super();
            code().load(this.codeUrl);
            relations().load(this.relationsUrl);
            this.referralCode = referralCode;
            this.flag = flag;
        },

        /**
         * Is form loaded
         */
        visible: ko.computed(function() {
            return code().loaded() && relations().isLoaded();
        }),

        /**
         * Get customer code
         */
        getCode: ko.computed(function() {
            let get = code().get();
            referralCode(get);
            get ? flag(true) : null;
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
        }),

        /**
         * Get referrals array
         */
        getReferrals: ko.computed(function(){
            return relations().get();
        }),

        /**
         * Remove relation
         * @param value
         */
        removeRelation: function(value) {
            console.log(value.id);
        }
    });
});