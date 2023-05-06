/**
 * Hide notification alert dismissible
 * @type {{init(*=): void, hideEl(*=): void}}
 */
export let alertDismissible = {
    init(el) {
        let isHideAlert = $(el).attr('data-hide')
        if(isHideAlert && isHideAlert === true || isHideAlert && isHideAlert === 'true') {
            let hideTime = $(el).attr('data-hide-time')
            hideTime !== undefined && hideTime !== '' ? hideTime : hideTime = 5
            this.hideEl(el, hideTime)
        }
    },

    /**
     * Hide alert
     * @param el - class alert's
     * @param hideTime - time in seconds for close
     */
    hideEl(el, hideTime) {
        $(el).delay(Number(hideTime) * 1000).slideUp(500, function() {
            $(this).alert('close')
        })
    }
}
