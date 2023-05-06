/**
 *  Use for send form data with ajax
 *
 *  Possible to send 1 or more files
 *  For all files attribute name will be added ordinal number
 *
 * @type {{submit_init: Function}}
 */

import { alerts } from './alerts.js';
import { Sendform } from "../../libs/sendform/sendform2";
import { Updating } from "./updating";

export class AjaxForm {
    constructor(form){
        this.form = form;
        this.modalHide = true;
        this.modalHideControlAttribute = 'data-modal-hide';
    }

    /*destroy(baseObject, refName) {
        delete baseObject[refName];
    }*/

    successSubmit(data, resultBlock, replaceBlk, msgSuccess, msgSuccessTxt, contentType = false) {
        let dataTxt = ''
        if(contentType) {
            dataTxt = JSON.parse(data)
        }
        if(msgSuccess && dataTxt) {
            alerts.success(dataTxt.header, dataTxt.message)
        } else if(msgSuccess && msgSuccessTxt){
            let msg = msgSuccessTxt.replace(/'/g, '"')
            msg = JSON.parse(msg)
            alerts.success(msg.title, msg.text)
        } else if(msgSuccess){
            alerts.success('', app.translate.success)
        }
        $('.form-group').removeClass('has-error');
        $('.help-block').html('');
        this.insertResult(data, resultBlock, replaceBlk);
    }


    errorSubmit(data, msgError) {
        $('.form-group').removeClass('has-error');
        $('.help-block').html('');

        let error_msg = [];

        if(!msgError) return; //not show messages

        if(data === undefined || ( !data && !data.errors)){
            alerts.error(app.translate.error);
            return;
        }

        $.each(data.errors, (idx, el) => {
            console.log(idx)
            console.log(el)
            error_msg.push(`${el} </br>`);
            this.validation_input(idx, el);

            let inputName = Object.keys(data.errors)[0];
            let nameEl = '';
            if (inputName.includes('.')) {
                let nameStr = inputName.split('.');
                let newNameStr = '';
                nameStr.map((val, i) => {
                    if (i === 0) {
                        newNameStr += val
                    } else {
                        newNameStr += `[${val}]`
                    }
                })
                nameEl = newNameStr
            } else {
                nameEl = el
            }
            let $inpFirst = $(`[name='${nameEl}']`);
            if($inpFirst && $inpFirst.length) {
                $('html, body').animate({
                    scrollTop: $inpFirst.offset().top - 65,
                }, 200);
            }
        });

        alerts.error(data.message, error_msg);

    }

    init(formClass = this.form){
        let _this= this;
        $(formClass).each(function( index ) {
            let $thisForm = $(this);

            let method = $thisForm.attr('method') === undefined ? "POST" : $thisForm.attr('method');
            let actionEl = $thisForm.data('action-from-child') === undefined ? '' : $thisForm.data('action-from-child');
            let resultBlock = $thisForm.data('result') === undefined ? '' : $thisForm.data('result');
            let replaceBlock = $thisForm.data('replace-blk') === undefined ? '' : $thisForm.data('replace-blk');
            let sendAllCheckbox = $thisForm.data('send-all-checkbox') === undefined ? false : $thisForm.data('send-all-checkbox');
            let msgSuccess = $thisForm.data('success-msg') === undefined ? true : $thisForm.data('success-msg');
            let msgSuccessTxt = $thisForm.data('success-msg-txt') === undefined ? '' : $thisForm.data('success-msg-txt');
            let msgError = $thisForm.data('error-msg') === undefined ? true : $thisForm.data('error-msg');

            let sendForm =  new Sendform($thisForm[0], {
                method,
                actionEl,
                sendAllCheckbox,
                success: (data) => {
                    if($(_this.form).closest('.js_base_modal_empty').length && _this.shouldHideModal()){
                        let $modalWithForm = $('.js_base_modal_empty');
                        resultBlock = $modalWithForm.attr('data-result-blk') === undefined ? '' : $modalWithForm.attr('data-result-blk');
                        replaceBlock = $modalWithForm.attr('data-replace-blk') === undefined ? '' : $modalWithForm.attr('data-replace-blk');

                        $modalWithForm.modal('hide');
                    }
                    let contentType = data.getResponseHeader('Content-Type') === 'application/json'
                    _this.successSubmit(data.response, resultBlock, replaceBlock, msgSuccess, msgSuccessTxt, contentType);

                    sendForm.removeStatusText();
                    sendForm.removeSpinner();
                },
                error:  (data) => {
                    console.log(data)
                    _this.errorSubmit(JSON.parse(data.response), msgError);

                    sendForm.removeStatusText();
                    sendForm.removeSpinner();
                }
            });

            // Init modal hiding control
            _this.initModalHidingControlWithSubmitButtons(formClass)
        });
    }

    /**
     * Check of modal window should be closed if exists
     *
     * @returns {boolean|*|boolean}
     */
    shouldHideModal(){
        // Check if form has modal hide control attribute
        let attr = $(this.form).attr(this.modalHideControlAttribute);
        let attr_val = this.recognizeBoolAttribute(attr);

        if(attr_val !== undefined){
            return attr_val;
        }

        return this.modalHide;
    }

    /**
     * Initialize hide modal control based on the button attribute
     *
     * @param formClass
     */
    initModalHidingControlWithSubmitButtons(formClass){
        let _this = this;

        app.bodyEl.on('click', formClass +' [type=submit]', function (e) {
            let attr = $(this).attr(_this.modalHideControlAttribute);
            let attr_val = _this.recognizeBoolAttribute(attr);

            if(attr_val !== undefined){
                _this.modalHide = attr_val;
            }
        })
    }

    /**
     * Recognize boolean value from attribute
     *
     * @param value
     * @returns {string|boolean}
     */
    recognizeBoolAttribute(value){
        if(value == false || value === 'false'){
            return  false;
        }

        if(value == true|| value === 'true'){
            return  true;
        }

        return undefined;
    }


    validation_input(el, txt = ''){
        let $input;
        if (el.includes('.')) {
            let nameStr = el.split('.');
            let newNameStr = '';
            nameStr.map((el, i) => {
                if (i === 0) {
                    newNameStr += el
                } else {
                    newNameStr += `[${el}]`
                }
            })
            $input = $(`[name='${newNameStr}']`);
        } else {
            $input = $(`[name='${el}']`);
        }
        //if($input.is(':visible') && $input.attr('type') !== 'file'){
        if($input && $input.is(':visible')){
          $input.closest('.form-group').addClass('has-error');
          $input.addClass('error');
          $input.removeClass('success-valid');
          $input.after(`<p class="help-block __error">${txt}</p>`);
        }
    }

    /**
    *
    * @param data {html} - content for insert to block
    * @param resultBlock {string} - result block class
    * @param replaceBlk {string} - replace block class
    */
    insertResult(data, resultBlk, replaceBlk){
        if(replaceBlk !== '' && $(replaceBlk).length !== 0){

           let thisBlk = $(replaceBlk).replaceWithPush(data);
           let classThisBlk = ('.'+thisBlk[0].className.match(/[\d\w-_]+/g).join('.'));

           app.initPluginsInWrapper(classThisBlk);

           if(thisBlk[0].className.split(' ').indexOf('js-update') !== -1){
                new Updating(classThisBlk).init();
           }
        }
        if(resultBlk !== '' && $(resultBlk).length !== 0){
          $(resultBlk).html(data);
          app.initPluginsInWrapper(resultBlk);
        }
    }
}

$(document).ready(function() {
  /**
   * Create jQuery function.
   */
  (function ($) {
    $.fn.replaceWithPush = function(el) {
      let $el = $(el);

      this.replaceWith($el);

      return $el;
    };
  })(jQuery);
});

