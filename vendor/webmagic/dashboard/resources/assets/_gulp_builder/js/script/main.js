/**
 * Base app object
 * @type {{init: Function}}
 */

import { getToken } from '../libs/getToken';
import { getLocale } from './components/locale';

import { SendAjaxFromEl } from "./components/ajax_el";
import { AjaxForm }  from './components/ajax_form.js'
import { AjaxBlk } from "./components/ajax_blk";

import { ControlStateEl } from "./components/change_state_el"
import { Updating } from "./components/updating";
import { item } from './components/item.js';
import { Datatime_picker } from './components/data_range.js'
import { fields } from './components/requests.js'
import { sortable } from './components/sortable.js'
import { Graphic } from './components/graphics';
import { select } from './components/select.js'
import { DropZone } from "./components/dropzone";

import { Uploader } from "./components/uploader";
import '../../node_modules/bootstrap/dist/js/bootstrap.min';

import { UploadFilePond } from "./components/filepond";

import {Editable} from "./components/editable";

import  '../../node_modules/overlayscrollbars/js/jquery.overlayScrollbars';
import  '../../node_modules/overlayscrollbars/js/OverlayScrollbars';
import '../../node_modules/admin-lte/dist/js/adminlte';
import '../../node_modules/glyphicons/glyphicons';

import {controls} from "./components/controls";
import { copyContent } from "./components/copy_cnt";
import { ui } from './components/ui_components.js';

import { SimpleDateTimePicker } from './components/data_picker';

import 'prismjs';
import 'prismjs/components/prism-clike';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-php';

$(document).ready(function() {
    global.app = new App();
    global.app.init();
});

class App {
    constructor(){
        let localeSettings = getLocale();
        this.locale = localeSettings.locale ;
        this.csrf_token = getToken();
        this.bodyEl = $('body');
        this.translate = controls.getTranslate(this.locale);
        this.main_ajax_form = null;
    }

    init() {
        ui.getSlugUrl('.js_get-slug');
        ui.addScrollClass('.js_scroll-top');
        //Init filePond
        //this.uploadFilePondInit();

        this.initPluginsInWrapper();
        copyContent.init('.js_copy-cnt');
        //init copy element (clone)
        ui.copyElement('.js_clone-el', '.js_clone-add', '.js_clone-remove', '.js_clone-blk', '.js_clone-wrap', '.js_clone-cnt');
        ui.copyMultiElement('.js_clone-multi-el', '.js_clone-multi-add', '.js_clone-multi-remove', '.js_clone-multi-blk', '.js_clone-multi-wrap', '.js_clone-cnt');
        //init checked checkboxes in table
        ui.initCheckedAllTable('.js_select-all');

        ui.initResetInputsWithPlugin();
        ui.addMask('.js_set-mask');
        ui.inputFile('.js_ui-input-file');

        //
        item.create_btn_init('.js_create');
        item.delete_btn_init('.js_delete');

        //init data tables
        // dataTables.init('.js_data_table');

        //init image uploading
        // image.uploadPreview('.js_image-preview');

        //ui.initCheckedAll('.js_select-all');
        //Init checked all on parent checkbox
        ui.initCheckedSome('.js_select-some');
        //Init checked all on child checkbox
        ui.initUnCheckedSome('js_select-some-');
        //Init checked all on button
        ui.initCheckedSomeBtn('.js_select-some-btn', '.js_select-some', 'js_select-some-');
        //Init checked all on select
        ui.initCheckedSomeSelect('.js_select-some-wrap', 'js_select-some-el', '.js_select-some', 'js_select-some-');

        //Init multi fields
        fields.init({
            src: '.js-src',
            dest: '.js-copy-dest',
            item: '.js-copy-item',
            add_btn:  '.js-add',
            remove_btn: '.js-remove'
        });

        //init all graphics
        this.initAllGraphics();
        //Init dropzone
        this.dropzoneInit();
        //Init uploader
        this.uploaderInit();

       /* // Init Daterangetimepicker plugin
        $('.js_datetime_picker').each(function () {
            let datatimepicker = new Datatime_picker(this);
            datatimepicker.init();
        });*/

        // Delete tooltip
        $('.js_hide-tooltip').each(function() {
            $(this).tooltip('disable');
        });
        /**
         * Initialize ajax sending form
         */

        let pagination = new SendAjaxFromEl('.js_btn-pagination', 'click', this.initPluginsInWrapper);
        pagination.onInit();

        let sendAjaxByClick = new SendAjaxFromEl('.js_ajax-by-click-btn', 'click', this.initPluginsInWrapper);
        sendAjaxByClick.onInit();

        let sendAjaxByChange = new SendAjaxFromEl('.js_ajax-by-change', 'change', this.initPluginsInWrapper);
        sendAjaxByChange.onInit();

        let sendFormByClickEl = new SendAjaxFromEl('.js_submit-form-by-click-el', 'click', this.initPluginsInWrapper, true);
        sendFormByClickEl.onInit();
        let sendFormByChangeEl = new SendAjaxFromEl('.js_submit-form-by-change-el', 'change', this.initPluginsInWrapper, true);
        sendFormByChangeEl.onInit();

        /**
         * Initialize sending ajax request with data from block (without form)
         */
        let submitDateFromBlk = new AjaxBlk('.js_ajax_blk-blk-submit', '.js_ajax_blk-btn-submit');
        submitDateFromBlk.init();
    }

    /**
     * Temporary global for reinitialization
     */
    globalAjaxFormReInit() {
        this.main_ajax_form = new AjaxForm('.js-submit');
        this.main_ajax_form.init();
    }

    initPluginsInWrapper(wrapper = ''){
      // console.log('init plugin  ' + wrapper)

      // Init Daterangetimepicker plugin
      $(wrapper + ' ' + '.js_datetime_picker').each(function () {
            let datatimepicker = new Datatime_picker(this);
            datatimepicker.init();
      });

      // Init SimpleDateTimePicker plugin
      $(wrapper + ' ' + '.js_simple_date_time_picker').each(function() {
            let dateTimePicker = new SimpleDateTimePicker(this);
          dateTimePicker.init();
      });

      //init all selects
      select.initDefaultSelect(wrapper + ' ' +'.js-select2');
      select.initSelectWithoutSearch(wrapper + ' ' +'.js_ui-base-select');
      select.initSelectedAll(wrapper + ' ' +'.js_ui-checkbox-selected-all');
      select.initSelectWithAjax(wrapper + ' ' + '.js-select2-ajax');

      ui.initLazyLoad(wrapper + ' ' +'.js-lazy');

      ui.inputFile(wrapper + ' ' +'.js_ui-input-file');

      // Sortable init, for now bower can't load library, and i commented it
      sortable.init(wrapper + ' ' + '.js-sortable');

      //init tooltip
      $(wrapper + ' ' +'*').tooltip({
        track: true,
      });
      $(wrapper + ' ' +'[title]').on("click", function() {
        $("div[role=tooltip]").remove();
      });
      $(wrapper + ' ' +'#menu *[title]').tooltip('disable');
      $(wrapper + ' ' +'[data-toggle="tooltip"]').tooltip("dispose");

      //init text editor
      //ui.editor_init(wrapper + ' ' +'.js-ckeditor');

      // Init Date-time piker plugin
      $(wrapper + ' ' +'.js_datetime_picker').each(function () {
        let datatimepicker = new Datatime_picker(this);
        datatimepicker.init();
      });

      $(wrapper + ' ' +'.js_control-state').each(function () {
          let controlState = new ControlStateEl($(this));
          controlState.init();
      });

      $(wrapper + ' ' +'.js-update').each(function (i, el) {
        let updateCnt = new Updating(el);
        updateCnt.init();
      });

      let ajax_form = new AjaxForm(wrapper + ' ' + '.js-submit');
      ajax_form.init();

      if(wrapper == ''){
          this.main_ajax_form = ajax_form;
      }

      //init Color picker
      ui.colorPicker(wrapper + ' ' +'.js-color-pick');

      $(wrapper + ' ' +'.js_show-scroll').overlayScrollbars({
            className: "os-theme-light",
            sizeAutoCapable: true,
            scrollbars: {
                autoHide: "l",
                clickScrolling: true
            }
      });
      //init Summernote for textarea
      ui.initEditor(wrapper + ' ' +'.js_summernote');
      //init editable
      app.uploadFilePondInit()

      app.editableCnt()
      //Toggle block
      ui.initToggleBlk(wrapper + ' ' +'.js_toggle-btn');
    }

    /**
     * Init all graphics
     */
    initAllGraphics(){
        let $graphics = $('.js_graphic');
        if(!$graphics.length) return;

        $graphics.each(function(){

            let $graphicOptions = $(this).data('options');
            let $graphicData = $(this).data('chart-data');
            if($graphicOptions == undefined) return;
            if($graphicData == undefined) $graphicData = {};

            let objOptionsGraphic = JSON.parse(JSON.stringify($graphicOptions));

            let objOptionsData = JSON.parse(JSON.stringify($graphicData));

            let graphic = new Graphic(objOptionsGraphic, objOptionsData);
            graphic.init();
        });
    }

    /**
     * Init dropzone
     *
     * to more information go to dropzone init file
     */
    dropzoneInit(){
        let $dropzoneInit = $('.js_dropzone-init');
        if(!$dropzoneInit.length) {
            return;
        }

        // each element init
        $dropzoneInit.each((i, el)=>{
            // get name of class if need, to have ability affect to each class
            let name = $(el).data('class-name');

            if(!name) {
                name = `dropzone_${i}`;
            }

            if(this[name] !== undefined){
                console.error('Error in file main.js on function dropzoneInit, try to init class with name which already exist - ' + name);
                return false;
            }

            this[name] = new DropZone({
                initClass: el,
                btnSubmitImages: '.js_dropzone-submit',
                availableOptionsFromDataAttr : [
                    'maxFilesize',
                    'paramName',
                    'uploadMultiple',
                    'addRemoveLinks',
                    'acceptedFiles',
                ]
            });

            this[name].init();
        });
    }

    //Fine Uploader
    uploaderInit(){
        let $uploader  = $('.js_uploader');
        if(!$uploader.length) {
            return;
        }

        // each element init
        $uploader.each((i, el)=>{
            // get name of class if need, to have ability affect to each class
            let name = $(el).data('class-name');

            if(!name) {
                name = `uploader_${i}`;
            }

            if(this[name] !== undefined){
                console.error('Error in file main.js on function uploaderInit, try to init class with name which already exist - ' + name);
                return false;
            }

            this[name] = new Uploader({
                element: el,
                availableOptionsFromDataAttr : [
                    'itemLimit',
                    'request-endpoint',
                    'deleteFile-endpoint',
                    'deleteFile-enabled',
                    'sizeLimit'
                ]
            });

            this[name].init();
        });

    }

    //filePond plugin init
    uploadFilePondInit(){
        let $uploaderFile = $('.js_filepond');
        if(!$uploaderFile.length) {
            return;
        }
        $uploaderFile.each((i, el)=>{
            let filePondEl = new UploadFilePond({
                element: el
            });
            filePondEl.init();
        });
    }

    editableCnt(){
        let editable = new Editable({
            elWrap: '.js_editable-wrap',
            el: '.js_editable-cnt',
            btnWrap: '.js_editable-controls',
            btnRemove: '.js_editable-remove',
            btnSave: '.js_editable-save',
        });
        editable.init();
    }
}

 import { Slider } from '../libs/slider';
 import {Sendform} from '../libs/sendform/sendform2';
 import { MfPopup } from '../libs/popup/mfpopup';
 import { AjaxPopup } from '../libs/popup/ajaxPopup';
 import { MagicPopup } from '../libs/popup/magicPopup';
 import {Filter} from '../libs/filter';
$( document ).ready(function() {
    if(NODE_ENV === 'dev'){
        console.log('its dev mode use prod mode for production');
    }
    let projectApp = new App();
    global.app = projectApp;
    projectApp.init();
});
