import { alerts } from './alerts';

import '../../libs/spinner';
import { Updating } from "./updating";
import { modals } from './modals.js';
import { controls } from './controls.js';
import {Sendform} from "../../libs/sendform/sendform2";
import {AjaxForm} from "./ajax_form";


/**
 * Use to sending data attributes  with ajax
 *
 * @param btnClass {string}  - click button class
 * @param typeEvent {string} - name event
 * @param parentForm {boolean} -class parent for submit
 * @param initPluginFunction {Function} -callback for reinit plugins
 *
 */

export class SendAjaxFromEl{

  constructor(btnClass, typeEvent, initPluginFunction,  parentForm ){

    this.btn = btnClass;
    this.typeEvent = typeEvent;
    this.initPlugin = initPluginFunction;

    this.parentForm = parentForm === true ? parentForm : false;

    this.method = "POST";
    this.action = '/';
    this.data = {};

    this.resultBlk ='';
    this.replaceBlk ='';
    this.modal = false;
    this.modalHide = true;
    this.confirm = {
      status: true,
      ttl: '',
      cnt: '',
      btnTxt: '',
      btnCancelTxt: ''
    };
    this.modalTtl = '';
    this.modalSize = '';
    this.reloadAfterCloseModal = false;
    this.reloadAfterSuccess = false;
    this.successMsg = true;
    this.successMsgTxt = '';
    this.errorMsg = true;
    this.formEl = null
  }

  /**
   * init function
   */
  onInit(){
    let _this = this;

    app.bodyEl.on(this.typeEvent, this.btn, function(e){
      if(e.type === 'click'){
        e.preventDefault();
      }
      _this.getConfirmData($(this));

      if(_this.parentForm){
        let $elForSubmit = $($(this).attr('data-form'));
        if($elForSubmit.length != 0){
          _this.formEl = $elForSubmit
          _this.data = _this.getData($elForSubmit);
          if($(this).attr('data-modal-hide') == false || $(this).attr('data-modal-hide') == 'false' || $(this).attr('data-modal-hide') == '0'){
            _this.modalHide = false;
          }else{
            _this.modalHide = true;
          }

        }
      }else{
        _this.data = _this.getData($(this));
      }


      if(_this.confirm.status){
        _this.showConfirmModal();
      }else{
        _this.addSpinner('formsendHover', 'form-loading');
        _this.sendRequest();
      }

    });
    let $modal_result = $('.js_base_modal_empty');
    $modal_result.on('hidden.bs.modal', function() {
      $modal_result.removeAttr('data-result-blk').removeAttr('data-replace-blk');
    });
  }
  showConfirmModal(){
    let _this = this;
    let $modal_el = $('.js_base_modal');

    modals.set_content($modal_el, this.confirm.ttl, this.confirm.cnt, this.confirm.btnTxt, this.confirm.btnCancelTxt);

    $modal_el.one('click', '.js_confirm_btn', ()=> {
      $modal_el.modal('hide');
      _this.addSpinner('formsendHover', 'form-loading');
      _this.sendRequest();
      $modal_el.off('click', '.js_confirm_btn');
    });
    $modal_el.on('hidden.bs.modal', function (e) {
      $modal_el.off('click', '.js_confirm_btn');
    });

    $modal_el.modal();
  }
  addSpinner(idSpinner, classLoader){
    if($(this.btn).closest('.js_base_modal_empty').length !== 0){
      $('.js_base_modal_empty .modal-content').spinnerAdd(idSpinner, classLoader);
      return;
    }

    if($(this.resultBlk).length !== 0){
      $(this.resultBlk).spinnerAdd(idSpinner, classLoader);
      return;
    }
    if($(this.replaceBlk).length !== 0){
      $(this.replaceBlk).spinnerAdd(idSpinner, classLoader);
      return;
    }
    $.spinnerAdd(idSpinner, classLoader)
  }
  /**
   * get data from button
   *
   * @param el - button with data attributes
   */
  getData(el){
    let data = el.data()

    if(el.attr('data-replace-blk') !== undefined ){
      this.replaceBlk = el.attr('data-replace-blk');
    } else {
       this.replaceBlk = undefined
    }
    if(data.replaceBlk !== undefined){
      delete data.replaceBlk;
    } else {
      data.replaceBlk = undefined
    }
    if(el.attr('data-result-blk') !== undefined ){
      this.resultBlk = el.attr('data-result-blk');
    }
    if(data.resultBlk !== undefined ){
      delete data.resultBlk;
    }

    if(el.attr('data-modal') !== undefined){
        this.modal = el.attr('data-modal');
        this.modalTtl = el.attr('data-modal-ttl') !== undefined ? el.attr('data-modal-ttl') : '';
        this.modalSize = el.attr('data-modal-size') !== undefined ? el.attr('data-modal-size') : '';
        this.reloadAfterCloseModal = el.attr('data-reload-after-close-modal') !== undefined ?  el.attr('data-reload-after-close-modal') : false;
    } else {
        this.modal = false;
    }

    if(data.modal !== undefined){
      delete data.modal;
      delete data.modalTtl;
      delete data.modalSize;
      delete data.reloadAfterCloseModal;
      delete data.reloadAfterSuccess;
    }


    if(data.confirm !== undefined){
      delete data.confirm;
      delete data.confirmTtl;
      delete data.confirmCnt;
      delete data.confirmBtnTxt;
      delete data.confirmBtnCancelTxt;
    }

    if(el.attr('data-modal-hide') == false || el.attr('data-modal-hide') == 'false' || el.attr('data-modal-hide') == '0'){
      this.modalHide = false;
    }else{
      this.modalHide = true;
    }

    if(data.modalHide !== undefined){
      delete data.modalHide;
    }

    if(data.reloadAfterSuccess !== undefined){
      delete data.reloadAfterSuccess;
    }

    if(el.attr('data-reload-after-success') !== undefined){
      this.reloadAfterSuccess = el.attr('data-reload-after-success') == 'true' || el.attr('data-reload-after-success') == 1 ?  true : false;
    }

    if(data.successMsg !== undefined){
      this.successMsg = data.successMsg;
      delete  data.successMsg;
    }
    if(data.successMsgTxt !== undefined){
      this.successMsgTxt = data.successMsgTxt;
    } else {
      this.successMsgTxt = ''
    }

    if(data.errorMsg !== undefined){
      this.errorMsg = data.errorMsg;
      delete  data.errorMsg;
    }

    //the el is form
    if(el.is('form')){
      return this.getDataForm(el, data)
    }

    //the el is not form
    if(data.method !== undefined){
      delete data.method;
    }
    if(el.attr('data-method') !== undefined){
      this.method = el.attr('data-method');
    }

    if(data.action !== undefined ){
      delete data.action;
    }
    if(el.attr('data-action') !== undefined ){
      this.action = el.attr('data-action');
    }

    //remove data  plugins
    data = this.removePluginAttributes(data);

    //for element form (example: checkbox or select)
    let nameEl = el.attr('name');

    if(!(nameEl == undefined || nameEl == '') ){
      if(el[0].type && el[0].type === 'checkbox'){
        if(el[0].checked){
          data[nameEl] = 1;
        }else {
          data[nameEl] = 0;
        }
      }else{
        data[nameEl] = el.val();
      }
    }
    data._token = app.csrf_token;
    console.log (data['bs.tooltip']);
    return data;
  }
  getConfirmData(el){
    this.confirm.status = (el.attr('data-confirm') == true ||
          el.attr('data-confirm') == 'true' ||
          el.attr('data-confirm') == 1) ? true : false;

    if(el.attr('data-confirm') !== undefined){

      this.confirm.ttl = el.attr('data-confirm-ttl') !== undefined ? el.attr('data-confirm-ttl') : app.translate.modalConfirmTtlDefault;
      this.confirm.cnt = el.attr('data-confirm-cnt') !== undefined ? el.attr('data-confirm-cnt') : app.translate.modalConfirmCntDefault;
      this.confirm.btnTxt = el.attr('data-confirm-btn-txt') !== undefined ? el.attr('data-confirm-btn-txt') : app.translate.modalConfirmBtnTxtDefault;
      this.confirm.btnCancelTxt = el.attr('data-confirm-btn-cancel-txt') !== undefined ? el.attr('data-confirm-btn-cancel-txt') : app.translate.modalConfirmBtnCancelTxtDefault;
    }
  }
  removePluginAttributes(data){
    if(data['bs.tooltip'] !== undefined) {
      delete data['bs.tooltip'];
    }
    if(data['select2'] !== undefined){
      delete data['select2'];
    }
    if(data['datepicker'] !== undefined){
      delete data['datepicker'];
    }
    return data;
  }

  /**
   * @param form {el}
   * @param data {object}
   */
  getDataForm(form, data){
    if(form.attr('action') !== undefined){
      this.action = form.attr('action');
    }
    if(form.attr('method') !== undefined){
      this.method = form.attr('method');
    }

    //checkbox
    let checkbox = form.find("input[type=checkbox]");

    checkbox.each(function(item, el){
      if (el.checked) {
        el.value = 1
      }
      if (data.sendAllCheckbox && !el.checked) {
        el.value = 0
      }
    });
    return form.serialize()
  }
  /**
   * ajax request
   */
  sendRequest(){
    let _this = this;
    if(this.method.toUpperCase() !== 'GET' && this.method.toUpperCase() !== 'POST'){
      this.data._method = this.method;
      this.method = 'POST';
    }
    this.data = this.removePluginAttributes(this.data);

    //image
    if (this.formEl && $(_this.formEl).find("input[type=file]")) {
      let method = $(_this.formEl).attr('method') === undefined ? "POST" : $(_this.formEl).attr('method');
      let actionEl = $(_this.formEl).data('action-from-child') === undefined ? '' : $(_this.formEl).data('action-from-child');
      let sendAllCheckbox = $(_this.formEl).data('send-all-checkbox') === undefined ? false : $(_this.formEl).data('send-all-checkbox');
      _this.replaceBlk = $(_this.formEl).data('replace-blk') === undefined ? '' : $(_this.formEl).data('replace-blk');
      let sendForm =  new Sendform(_this.formEl[0], {
        method,
        actionEl,
        sendAllCheckbox,
        success: (data) => {
          $.spinnerRemove('formsendHover', 'form-loading')
          let contentType = data.getResponseHeader('Content-Type') === 'application/json'
          let dataTxt = ''
          if(!contentType) {
            dataTxt = data.response
          }
          if (data.redirect !== undefined) {
            _this.addSpinner('formsendHover', 'form-loading')
            window.location.replace(data.redirect)
            return;
          }
          this.successSubmit(dataTxt)
        },
        error: (data) => {
          let contentType = data.getResponseHeader('Content-Type') === 'application/json'
          this.errorSubmit(data.response, contentType);
        }
      })

      $(_this.formEl).submit();
    } else {
      $.ajax({
        url: this.action,
        method: this.method,
        data: this.data,
        success: (data) => {
          if (data.redirect !== undefined) {
            _this.addSpinner('formsendHover', 'form-loading');
            window.location.replace(data.redirect);
            return;
          }
          this.successSubmit(data);
        },
        error: (data) => {
          this.errorSubmit(data);
        }
      })
    }

  }

  /**
   * append data to resultBlk
   * @param data - data from back
   */
  successSubmit(data){
    let _this = this
    let $modalCnt = $('.js_base_modal_empty');
    if(this.modal && !$modalCnt.is(":visible")){
      $.spinnerRemove('formsendHover', 'form-loading');

      $modalCnt.attr('data-result-blk', this.resultBlk);
      $modalCnt.attr('data-replace-blk', this.replaceBlk);
      $modalCnt.attr('data-reload-after-close-modal', this.reloadAfterCloseModal);

      /*reload page after close modal */
      if(this.reloadAfterCloseModal){
        $modalCnt.on('hidden.bs.modal', () => {
          _this.addSpinner('formsendHover', 'form-loading');
          location.reload();
        })
      }
      $modalCnt.modal('show').find('.modal-body').html(data);

      $modalCnt.find('.modal-dialog').addClass(this.modalSize);

      $modalCnt.find('.modal-header .modal-title').remove();
      $modalCnt.find('.modal-header').prepend('<h4 class="modal-title">'+this.modalTtl+'</h4>');

      //reinit plugin
      if(typeof  this.initPlugin == 'function') {
        this.initPlugin('.js_base_modal_empty');
      }
      return;
    }

    if($(this.btn).closest('.js_base_modal_empty').length !== 0 && this.modalHide){
      this.resultBlk = $modalCnt.attr('data-result-blk') === undefined ? '' : $modalCnt.attr('data-result-blk');
      this.replaceBlk = $modalCnt.attr('data-replace-blk') === undefined ? '' : $modalCnt.attr('data-replace-blk');
      $modalCnt.modal('hide');

    }
    if(this.replaceBlk !=='' && $(this.replaceBlk).length !== 0){
      let thisBlk = null
      thisBlk = $(this.replaceBlk).replaceWithPush(data)
      if(typeof  this.initPlugin == 'function'){
        let classThisBlk = ('.'+thisBlk[0].className.match(/[\d\w-_]+/g).join('.'));
        this.initPlugin(classThisBlk);
        if(thisBlk[0].className.split(' ').indexOf('js-update') !== -1){
          new Updating(classThisBlk).init();
        }
      }
      $.spinnerRemove('formsendHover', 'form-loading');
      return;
    }

    if(this.resultBlk !=='' && $(this.resultBlk).length !== 0){
      $(this.resultBlk).html(data);
      if(typeof  this.initPlugin == 'function') {
        this.initPlugin(this.resultBlk);
      }
    }
    if(this.successMsg && data.header || this.successMsg && data.message){
      alerts.success(data.header , data.message)
    } else if(this.successMsg && this.successMsgTxt){
      let msg = this.successMsgTxt.replace(/'/g, '"')
      msg = JSON.parse(msg)
      alerts.success(msg.title, msg.text)
    } else if(this.successMsg) {
      alerts.success('', app.translate.success);
    }
    $.spinnerRemove('formsendHover', 'form-loading');

    if(this.reloadAfterSuccess){
      _this.addSpinner('formsendHover', 'form-loading');
      location.reload();
    }
  }

  /**
   * error function
   *
   * @param data - data from back
   */
  errorSubmit(data, contentType = false){
    $.spinnerRemove('formsendHover', 'form-loading');

    $('.form-group').removeClass('has-error');
    $('.help-block').html('');

    let error_msg = [];

    if (data === undefined || (!data && !data.responseJSON.errors)) {
      alerts.error(app.translate.error);
      return
    }
    let dataObj = ''
    if(contentType) {
      dataObj = JSON.parse(data).errors;
    } else {
      dataObj = data.responseJSON.errors;
    }

    $.each(dataObj, (idx, el) => {
      error_msg.push(`${el} </br>`);
      this.validation_input(idx, el);

      let inputName = Object.keys(dataObj)[0];
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


    /*$('.form-group').removeClass('has-error');
    $('.help-block').html('');

    let error_msg = [];

    if (data === undefined || (!data && !data.responseJSON.errors)) {
      alerts.error(app.translate.error);
      return
    }

    let dataObj = data.responseJSON;
    $.each(dataObj.errors, (el) => {
      let errMsg = dataObj.errors[el];
      error_msg.push(`${errMsg} </br>`);
    });

    alerts.error(app.translate.error, error_msg)*/








    /*if(data === undefined || ( !data.responseJSON && !data.responseJSON.errors)){
      console.log(1)
      if(this.errorMsg) alerts.error('Error');
      return;
    }
    if(this.errorMsg) {
      alerts.error(app.translate.error, data.responseJSON.errors);
      /!*console.log(data.responseJSON.errors)
      alerts.error(data.responseJSON.errors);*!/
    }*/
  }

  validation_input(el, txt = '') {
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

}
