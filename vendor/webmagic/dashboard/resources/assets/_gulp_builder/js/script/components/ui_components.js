import '../../../node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min';
import urlSlug from 'url-slug'
// import urlSlug from '../../libs/urlSlug'

import { alerts } from "./alerts";

import '../../../node_modules/jquery-lazy/jquery.lazy.min';
import '../../../node_modules/jquery-lazy/jquery.lazy.plugins.min';
//import '../../../node_modules/summernote/dist/summernote.min';
//import '../../../node_modules/summernote/dist/summernote-bs4.min';
import {getToken} from "../../libs/getToken";
import '../../libs/summernote';

import Inputmask from "inputmask";
import {AjaxForm} from "./ajax_form";
import {alertDismissible} from './alert_dismissible';
import {Datatime_picker} from "./data_range";
/**
 * User interface elements init
 *
 */
export let ui = {

    /**
     * add mask for input
     * @param inputs
     */
    addMask(inputs) {
        if($(inputs).length === 0){
            return;
        }
        $(inputs).each((i, inp) => {
            let inpMask = $(inp).attr('data-regex');
            let inpMaskPlace = $(inp).attr('data-mask');

            let im = new Inputmask({
                regex: inpMask.toString(),
                placeholder:inpMaskPlace.toString()
            });
            im.mask(inp);
        })
    },

    initEditor(elementClass){
        $(elementClass).each(function(){
            let urlUpload = $(this).attr('data-upload-url');
            let disabled = $(this).attr('disabled');
            let urlOnBlur = $(this).attr('data-blur-url');
            let isShowSpinner = $(this).attr('data-show-spinner');
            //let isShowSpinner = true;
            let methodOnBlur = $(this).attr('data-blur-method') ? $(this).attr('data-blur-method') : 'POST';
            let showSuccessMsg = $(this).attr('data-success-msg');
            if (showSuccessMsg && showSuccessMsg === true || showSuccessMsg === 'true') {
                    showSuccessMsg = true
            } else {
                showSuccessMsg = false
            }
            let showErrorMsg = $(this).attr('data-error-msg');
            if (showErrorMsg && showErrorMsg === true || showErrorMsg === 'true') {
                showErrorMsg = true
            } else {
                showErrorMsg = false
            }
            if (isShowSpinner && isShowSpinner === true || isShowSpinner === 'true') {
                isShowSpinner = true
            } else {
                isShowSpinner = false
            }
            if (urlUpload) {
                $(this).summernote({
                    height: 200,
                    callbacks: {
                        onImageUpload: function (files) {
                            for (let i = 0; i < files.length; i++) {
                                sendFile(files[i], $(this), urlUpload);
                            }
                        },
                        onChange: function(contents) {
                            if(urlOnBlur) onChangeEl(contents, methodOnBlur, urlOnBlur, showSuccessMsg, showErrorMsg, false)
                        },
                        onBlurCodeview: function(contents) {
                            if(urlOnBlur) onChangeEl(contents, methodOnBlur, urlOnBlur, showSuccessMsg, showErrorMsg, isShowSpinner)
                        }
                    }
                });
            } else {
                $(this).summernote({
                    height: 200,
                    callbacks: {
                        onBlur: function(contents) {
                            if(urlOnBlur) onChangeEl(contents, methodOnBlur, urlOnBlur, showSuccessMsg, showErrorMsg, isShowSpinner)
                        },
                        onBlurCodeview: function(contents) {
                            if(urlOnBlur) onChangeEl(contents, methodOnBlur, urlOnBlur, showSuccessMsg, showErrorMsg, isShowSpinner)
                        }
                    }
                })
            }
            if (disabled === 'disabled' || disabled === true){
                $(this).summernote('disable');
            }
        });

        function onChangeEl(content, method, url, successMsg, errorMsg, isShowSpinner) {
            let data = {
                content: content.currentTarget.innerHTML,
                _token: getToken()
            }
            if(isShowSpinner) $.spinnerAdd()
            $.ajax({
                data: data,
                type: method,
                url: url,
                success: () => {
                    console.log(isShowSpinner)
                    $.spinnerRemove()
                    if(successMsg) alerts.success('', app.translate.success)
                },
                error: () => {
                    $.spinnerRemove()
                    if(errorMsg) alerts.error('', app.translate.error)
                }
            })
        }

        function sendFile(file, editor, action) {
            let data = new FormData();
            data.append("file", file);
            data.append("_token", getToken());
            $.spinnerAdd();
            $.ajax({
                data: data,
                type: "POST",
                url: action,
                cache: false,
                contentType: false,
                processData: false,
                success: function (url) {
                    editor.summernote('insertImage', url);
                    $.spinnerRemove();
                },
                error: function (e) {
                    alerts.error('', app.translate.error);
                    $.spinnerRemove();
                }
            });
        }
    },
    initLazyLoad(elClass){
        let $el = $(elClass);
        if($el.length === 0) return;
        $el.Lazy();
    },

    selectedAll(clickEl, isUnchecked = false){
        let stateCheckbox =  clickEl.prop('checked');
        let $allCheckboxForEl = $(clickEl.attr('data-checked-el'));
        // checkbox without plugin
        if (!isUnchecked) {
            $allCheckboxForEl.each(function() {
                $(this).prop('checked', stateCheckbox);
            });
        } else {
            if (stateCheckbox) {
                $allCheckboxForEl.each(function() {
                    $(this).prop('checked', false);
                });
            } else {
                $allCheckboxForEl.each(function() {
                    $(this).prop('checked', true);
                });
            }
        }
        ui.toggleCheckedAll($(clickEl).attr('data-checked-el'), isUnchecked);
    },

    initCheckedSome(elClass) {
        let $elSome = $(elClass);
        if($elSome.length > 0) {
            $elSome.each((i, el) => {
                if ($(el).is(':checked')) {
                    $(el).removeAttr('checked');
                    $(el).prop('checked', true);
                }
            })
        }
        app.bodyEl.on('change', elClass, function() {
            let isUnchecked = $(this).attr('data-unchecked');
            isUnchecked === true ||  isUnchecked === 'true' ? isUnchecked = true : isUnchecked = false;
            ui.selectedAll($(this), isUnchecked)
            let $parentEls = $(`.js_select-some`);
            $parentEls.each((i, el) => {
                let parentEl = $($(el).attr('data-checked-el'));
                if (parentEl.not(':checked').length === 0) {
                    if (!isUnchecked) {
                        $(el).prop('checked', true);
                    } else {
                        $(el).prop('checked', false);
                    }
                } else {
                    if (!isUnchecked) {
                        $(el).prop('checked', false);
                    } else {
                        $(el).prop('checked', true);
                    }
                }
            })
        });
    },

    /**
     * On click btn
     * @param elClass
     * @param elAll
     */
    initCheckedSomeBtn(btnClass, elAll, elClass) {
        app.bodyEl.on('click', btnClass, function(e) {
            e.preventDefault();
            let _this = this;
            let isUnchecked = $(this).attr('data-unchecked');
            let $uncheckedEl = $($(this).attr('data-unchecked-el'));
            isUnchecked === true || isUnchecked === 'true' ? isUnchecked = true : isUnchecked = false;
            let $allCheckbox = $(`input[class*='${elClass}']`)
            let $allCheckboxForEl = $($(_this).attr('data-checked-el'));
            if (!isUnchecked) {
                if ($uncheckedEl.length === 0) {
                    $allCheckbox.each(function () {
                        $(this).prop('checked', false);
                    })
                } else {
                    $uncheckedEl.each(function () {
                        $(this).prop('checked', false);
                    })
                }
            } else {
                if ($uncheckedEl.length === 0) {
                    $allCheckbox.each(function () {
                        $(this).prop('checked', true);
                    })
                } else {
                    $uncheckedEl.each(function () {
                        $(this).prop('checked', true);
                    })
                }
            }
            $allCheckboxForEl.each(function() {
                if (!isUnchecked) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            })
            ui.toggleCheckedAll($(_this).attr('data-checked-el'), isUnchecked);
            let $parentEls = $(elAll);
            $parentEls.each((i, el) => {
                let parentEl = $($(el).attr('data-checked-el'));
                if (parentEl.not(':checked').length === 0) {
                    $(el).prop('checked', true);
                } else {
                    $(el).prop('checked', false);
                }
            })
        });
    },

    /**
     * On select checked
     * @param elWrap
     * @param elClass
     * @param elParent
     * @param elChild
     */
    initCheckedSomeSelect(elWrap, elClass, elParent, elChild) {
        if($(elWrap).length > 0) {
            let $defaultSelected = $(elWrap).find('option:selected');
            let isUnchecked = $(elWrap).attr('data-unchecked');
            isUnchecked === true || isUnchecked === 'true' ? isUnchecked = true : isUnchecked = false;
            ui.checkedOnChangeSelect(elParent, elChild, $defaultSelected, isUnchecked);
        }
        app.bodyEl.on('change', elWrap, function(e) {
            e.preventDefault();
            let $elSelected = $(this).find('option:selected');
            let isUnchecked = $(this).attr('data-unchecked');
            isUnchecked === true || isUnchecked === 'true' ? isUnchecked = true : isUnchecked = false;
            if ($elSelected.hasClass(elClass)) {
                ui.checkedOnChangeSelect(elParent, elChild, $elSelected, isUnchecked)
            }
        })
    },

    checkedOnChangeSelect(elParent, elChild, $elSelected, isUnchecked) {
        let $parCheckbox = $(elParent);
        let $allCheckbox = $(`input[class*='${elChild}']`);
        let $allCheckboxForEl = $($($elSelected).attr('data-checked-el'));
        $allCheckbox.each(function () {
            $(this).prop('checked', false);
        })
        $parCheckbox.each(function() {
            $(this).prop('checked', false);
        })
        $allCheckboxForEl.each(function() {
            if (!isUnchecked) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        })
        if (!isUnchecked) {
            ui.toggleCheckedAll($($elSelected).attr('data-checked-el'), isUnchecked)
        }
    },

    /***
     * On checkbox checked
     * @param elClass
     */
    initUnCheckedSome(elClass) {
        let $elSome = $(elClass);
        if($elSome.length > 0) {
            $elSome.each((i, el) => {
                if ($(el).is(':checked')) {
                    $(el).removeAttr('checked');
                    $(el).prop('checked', true);
                }
            })
        }
        app.bodyEl.on('change', `input[class*='${elClass}']`, function() {
            let $defaultCheck = $(this).attr("class").split(" ").filter(el => {
                return el ? el.startsWith('js_select-some-') : ''
            })
            $defaultCheck.forEach((el) => {
                let isUnchecked = $(`.${el}`).attr('data-unchecked');
                isUnchecked === 'true' || isUnchecked === true? isUnchecked = true : isUnchecked = false
                ui.toggleCheckedAll(`.${el}`, isUnchecked);
            })
        })
    },

    toggleCheckedAll(allEl, isUnchecked) {
        let $elAll = $(allEl);
        let parentEl = $(`.js_select-some[data-checked-el="${allEl}"]`);
        if ($elAll.not(':checked').length === 0) {
            if (!isUnchecked) {
                parentEl.prop('checked', true);
            } else {
                parentEl.prop('checked', false);
            }
        } else {
            if (!isUnchecked) {
                parentEl.prop('checked', false);
            } else {
                parentEl.prop('checked', true);
            }
        }
    },

    /***
     * Init on checked only checkbox
     * @param el
     */
    initCheckedOnly(el) {
        app.bodyEl.on('change', el, function() {
            let $elBlk = $($(this).attr('data-checked-el'))
            let isChecked = $(this).prop('checked')
            if(isChecked) {
                $elBlk.each((i, item) => {
                    $(item).prop('checked', true);
                })
            }
        })
    },

    initResetInputsWithPlugin(){
        app.bodyEl.on('click', 'input[type="reset"]', function (e) {
           e.preventDefault();
           let $form = $(this).closest('form');

           //reset select
           let $selects = $form.find('.js-select2');
           $form.find("option:selected").removeAttr("selected");
           $selects.val(null).trigger('change');

           $form.find('.js_datetime_picker').attr('value', ''); // .val() and .value not working
           $form.find('.js_datetime_picker-end').attr('value', '');

           //reset ckeditor
           /*let $ckeditor = $form.find(".js-ckeditor");
           $ckeditor.each(function (i, el) {
               let idEl = el.id;
               CKEDITOR.instances[idEl].setData('');
           });*/
            let $summernote = $form.find(".js_summernote");
            $summernote.each(function(){
                $(this).summernote('code', '<p><br></p>');
            });

           $form.find('.js_ui-input-file-delete').trigger('click');
        })
    },
    inputFile(classInput){
        if(!$(classInput).length) return;

        let _URL = window.URL || window.webkitURL;
        app.bodyEl.on('change', classInput, function (e) {
            let $parant = $(this).closest('.js_ui-file-preview');
            let $nameImg = $parant.find('.js_ui-input-file-name');
            let $sizeImg = $parant.find('.js_ui-input-file-size');
            let $sizeWHImg = $parant.find('.js_ui-input-file-size-with-height');
            let $defaultImg = $parant.find('.js_ui-input-file-default-img');
            let $img = $parant.find('.js_ui-input-file-preview');
            let $downloadImg = $parant.find('.js_ui-input-file-download');

            if (this.files && this.files[0]) {
                let img = new Image();
                img.onload = function () {

                    $defaultImg.hide();
                    $img.attr('src',  img.src).fadeIn(200);
                    $downloadImg.attr('href',  img.src).removeClass('disabled');
                    $sizeWHImg.html(this.width + " * " + this.height + 'px');

                };
                img.src = _URL.createObjectURL(this.files[0]);

                $nameImg.text(this.files[0].name);
                $sizeImg.html(formatBytes(this.files[0].size));
            }
        });
        app.bodyEl.on('click', '.js_ui-input-file-delete', function (e) {
            e.preventDefault();
            let $parant = $(this).closest('.js_ui-file-preview');
            let $defaultImg = $parant.find('.js_ui-input-file-default-img');

            if($defaultImg.is(':visible')) return;

            let $nameImg = $parant.find('.js_ui-input-file-name');
            let $sizeImg = $parant.find('.js_ui-input-file-size');
            let $img = $parant.find('.js_ui-input-file-preview');
            let $inputFile = $parant.find(classInput);
            let $sizeWHImg = $parant.find('.js_ui-input-file-size-with-height');
            let $downloadImg = $parant.find('.js_ui-input-file-download');

            $defaultImg.fadeIn(200);
            $img.attr('src', '').hide();
            $inputFile.val('');
            $nameImg.html('');
            $sizeImg.html('');
            $sizeWHImg.html('');
            $downloadImg.attr('href', '').addClass('disabled');
        });
        function formatBytes(bytes, decimals) {
            if(bytes == 0) return '0 Bytes';
            var k = 1000,
                dm = decimals <= 0 ? 0 : decimals || 2,
                sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
                i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    },


    /**
     * init Color picker plugin
     *
     * @param el - element on which will be init plugin
     */
    colorPicker(el){
        $(el).each(function () {
            $(this).colorpicker({
                container: $(this).attr('data-parent-wrap')
            })
        })
    },


    /**
     * scroll to the top of the site
     *
     * @param el - button which you click on to scroll up.
     */

    addScrollClass(el){
        $(window).scroll(function() {
            if ($(window).scrollTop() > 50) {
                $(el).fadeIn(400);
            }
            else{
                $(el).fadeOut(400);
            }
        });
        app.bodyEl.on('click', el, function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $("body").offset().top - 100
            }, 500);
        })
    },

    /**
     * generate slug for url
     *
     * @param inpSlug - input which generate slug
     */
    getSlugUrl(inpSlug){
        let inpName = $(inpSlug).attr('data-source-name');
        let separatorSlug = $(inpSlug).attr('data-separator');
        let transformerSlug = $(inpSlug).attr('data-transformer');
        let transformer;

        let inpSource = $(inpSlug).closest('form').find('[name="'+inpName+'"]:first');

        $(inpSource).keyup(function(){
            let inpVal = $(this).val();

            if(transformerSlug === 'false'){
                transformer = false;
            }
            else if(transformerSlug === 'uppercase'){
                transformer = urlSlug.transformers.uppercase;
            }
            else{
                transformer = urlSlug.transformers.lowercase;
            }
            let resultSlug = urlSlug(inpVal, separatorSlug ? separatorSlug : '-', transformer ? transformer : urlSlug.transformers.lowercase);
            $(inpSlug).val(resultSlug);
        });
    },

    /**
     * Copy element
     */
    copyElement(el, btnAdd, btnRemove, elBlk, elWrap, elCnt) {
        let countEl = 1;
        let countItemEl = 0;
        let countElId = 0;
        ui.addCopyElement(countEl, el, btnAdd, btnRemove, elBlk, elWrap, countItemEl, countElId, elCnt);
        ui.removeCopyElement(countEl, el, btnRemove, elBlk, elWrap, elCnt, btnAdd);
    },

    addCopyElement(countEl, el, btnAdd, btnRemove, elBlk, elWrap, countItemEl, countElId, elCnt) {
        app.bodyEl.on('click', btnAdd, function(e) {
            e.preventDefault();
            let $elWrap = $(this).closest(elWrap);
            countItemEl = $elWrap.data('count-name');
            countElId = $elWrap.data('count-id');
            let maxCount = $(this).data('max-count');
            let $firstEl = $elWrap.find(`${elBlk}:first`);
            let copyEl = $firstEl.clone();
            copyEl.removeClass('__hidden-blk');
            ++countItemEl;
            $elWrap.data('count-name', countItemEl);
            copyEl.find(el).each((i, item) => {
                ++countElId;
                $elWrap.data('count-id', countElId);
                $(item).attr('name', `${$(item).attr('name').split('[')[0]}[${countItemEl}]`)
                    .attr('id', `field_${countElId}`)
                    .val('')
                    .removeAttr('disabled')
                    .removeAttr('value');
            });
            copyEl.find('.help-block').each((i, item) => {
                $(item).remove()
            });
            $elWrap.find(elCnt).append(copyEl);
            if ($elWrap.find(elCnt).find(elBlk).length === maxCount) {
                $(this).addClass('d-none');
            }
            app.initPluginsInWrapper(elWrap)
            app.globalAjaxFormReInit()
        })
    },

    removeCopyElement(countEl, el, btnRemove, elBlk, elWrap, elCnt, btnAdd) {
        app.bodyEl.on('click', btnRemove, function(e) {
            e.preventDefault();
            let $elWrap = $(this).closest(elWrap);
            let $currBtnAdd = $elWrap.find(btnAdd);
            let maxCount = $currBtnAdd.data('max-count');
            --countEl;
            if ($elWrap.find(elCnt).find(elBlk).length - 1 < maxCount) {
                $elWrap.find(btnAdd).removeClass('d-none');
            } else {
                $elWrap.find(btnAdd).addClass('d-none');
            }
            $(this).closest(elBlk).remove();
            app.globalAjaxFormReInit()
        })
    },

    /**
     * Copy multi fields
     * @param el
     * @param btnAdd
     * @param btnRemove
     * @param elBlk
     * @param elWrap
     */
    copyMultiElement(el, btnAdd, btnRemove, elBlk, elWrap, elCnt) {
        this.addMultiCopyElement(elWrap, elCnt, btnAdd, elBlk, el);
        this.removeMultiCopyElement(elWrap, elCnt, btnRemove, btnAdd, elBlk);
    },

    addMultiCopyElement(elWrap, elCnt, btnAdd, elBlk, el) {
        app.bodyEl.on('click', btnAdd, function(e) {
            e.preventDefault();
            let $elWrap = $(this).closest(elWrap);
            let maxCount = $elWrap.data('max-count');
            let $firstEl = $elWrap.find(`${elBlk}:first`);
            let entity = $firstEl.data('entity');
            let firstElId = $firstEl.data('id');
            let url = $(this).data('url');
            let method = $(this).data('method');
            let copyEl = $firstEl.clone();
            copyEl.removeClass('__hidden-blk');
            $.ajax({
                url,
                method: method ? method : 'POST',
                data: {
                    entity,
                    _token: getToken()
                },
                success: data => {
                    copyEl.find(el).each((i, item) => {
                        let nameEl = $(item).attr('name');
                        let idEl = $(item).attr('id');
                        $(item).attr('name', nameEl.replace(firstElId, data))
                               .attr('id', idEl.replace(firstElId, data))
                               .removeClass('error')
                               .val('')
                               .removeAttr('disabled')
                               .removeAttr('value');
                    });
                    copyEl.find('.help-block').each((i, item) => {
                        $(item).remove()
                    });
                    copyEl.attr('data-id', data);
                    $elWrap.find(elCnt).append(copyEl);
                    if ($elWrap.find(elCnt).find(elBlk).length === maxCount) {
                        $(this).addClass('d-none');
                    }
                    app.initPluginsInWrapper(elWrap)
                    app.globalAjaxFormReInit()
                }
            });
        })
    },

    removeMultiCopyElement(elWrap, elCnt, btnRemove, btnAdd, elBlk) {
        app.bodyEl.on('click', btnRemove, function(e) {
            e.preventDefault();
            let $elWrap = $(this).closest(elWrap);
            let maxCount = $elWrap.data('max-count');
            let url = $(this).data('url');
            let method = $(this).data('method');
            let entity = $(this).closest(elBlk).data('entity');
            let entityId = $(this).closest(elBlk).data('id');
            $.ajax({
                url,
                method: method ? method : 'POST',
                data: {
                    entity,
                    entity_id: entityId,
                    _token: getToken()
                },
                success: () => {
                    $(this).closest(elBlk).remove();
                    if ($elWrap.find(elCnt).find(elBlk).length < maxCount) {
                        $elWrap.find(btnAdd).removeClass('d-none');
                    } else {
                        $elWrap.find(btnAdd).addClass('d-none');
                    }
                    app.globalAjaxFormReInit()
                }
            });
        })
    },

    /**
     * Init hide alert dismissible
     * @param el - class alert block
     */
    hideAlertDismissible(el) {
        $(el).each(function() {
            alertDismissible.init(this);
        });
    },


    /**
     * Show/hide block on click element
     * @param btn
     */
    initToggleBlk(btn) {
        let blk = $(btn).attr('data-name-blk')
        let statusAction = $(btn).attr('data-show-blk')
        this.toggleVisibleBlk(btn, blk, statusAction)
        app.bodyEl.on('click', btn, function(e) {
            e.stopImmediatePropagation()
            if(!$(this).is(':checkbox')) e.preventDefault()
            blk = $(this).attr('data-name-blk')
            statusAction = $(this).attr('data-show-blk')
            ui.toggleVisibleBlk(this, blk, statusAction)
        })
    },

    toggleVisibleBlk(btn, blk, statusAction) {
        if (statusAction === undefined) {
            $(btn).attr('data-show-blk', '')
            $(blk).hide()
        } else {
            $(btn).removeAttr('data-show-blk')
            $(blk).show()
        }
    },

    initCheckedAllTable(elClass){
        app.bodyEl.on('change', elClass, function () {
            ui.selectedAllTable($(this))
        })
    },

    selectedAllTable(clickEl){
        let stateCheckbox =  clickEl.prop('checked')
        let $allCheckboxForEl = $(clickEl.attr('data-checked-el'))
        // checkbox without plugin
        $allCheckboxForEl.each(function() {
            $(this).prop('checked', stateCheckbox)
        })
    }

};
