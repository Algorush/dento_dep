import {getToken} from "../../libs/getToken";

export class Editable {
    constructor(controls) {
        this.elWrap = controls.elWrap;
        this.el = controls.el;
        this.btnWrap = controls.btnWrap;
        this.btnRemove = controls.btnRemove;
        this.btnSave = controls.btnSave;
        this.btnControls = `
                    <div class="editable-cnt d-flex justify-content-between">
                        <a href="" class="btn btn-success text-white editable-cnt-btn js_editable-save">
                            <i class="fas fas fa-check"></i>
                        </a>
                        <a href="" class="btn btn-danger text-white editable-cnt-btn js_editable-remove">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
            `
    }

    init() {
        this.addControlsIsEmpty();
        this.addControls();
        this.resetContent();
        this.removeChangedContent();
        this.addChangedContent();
    }

    addControlsIsEmpty() {
        let _this = this
        app.bodyEl.on('input', _this.el, function(e) {
            e.preventDefault()
            $(_this.btnWrap).html(_this.btnControls)
        })
    }

    addControls() {
        let _this = this;
        app.bodyEl.on('focus', _this.el, function(e){
            e.preventDefault()
            let $wrap = $(this).closest(_this.elWrap)

            if ($wrap.find(_this.btnWrap).length > 0) {
                return
            }

            let btnControls = `
                <div class="editable-controls js_editable-controls">
                    ${_this.btnControls}
                </div>
            `
            $(this).append(btnControls)
        })
    }

    resetContent() {
        let _this = this;
        app.bodyEl.on('focusout', _this.el, function(e) {
            e.preventDefault()
            let $wrap = $(this).closest(_this.elWrap)
            let $removeEl = $wrap.find(_this.btnWrap)
            if ($removeEl.length > 0) {
                $removeEl.remove()
            }
            let defaultCnt = $(this).data('default-content')
            $(this).html(defaultCnt)
        })
    }

    removeChangedContent() {
        let _this = this;
        app.bodyEl.on('click', _this.btnRemove, function(e) {
            e.preventDefault()
            let $wrap = $(this).closest(_this.elWrap)
            let $el = $wrap.find(_this.el)
            let defaultCnt = $el.data('default-content')
            $el.html(defaultCnt)
            $el.blur()
        })
    }

    addChangedContent() {
        let _this = this;
        app.bodyEl.on('click', _this.btnSave, function(e) {
            e.preventDefault()
            console.log(1)
            let $wrap = $(this).closest(_this.elWrap)
            let $el = $wrap.find(_this.el)
            $wrap.find(_this.btnWrap).remove()
            let defaultCnt = $el.data('default-content')
            let cnt = $el.html()
            let method = $el.data('method')
            let url = $el.data('url')
            let fieldName = $el.data('field-name')
            let data = {
                _token: getToken()
            }
            data[fieldName] = cnt
            $.ajax({
                url,
                method,
                data,
                success: () => {
                    $el.data('default-content', cnt)
                    $el.blur()
                },
                error: () => {
                    $el.html(defaultCnt)
                    $el.blur()
                }
            });
        })
    }
}
