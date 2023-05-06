//todo test this class, changed from old syntax
export let controls = {
    //Send simple AJAX request

  /**
   *
   * @param action {string}
   * @param method {string}
   * @param success_function {function}
   * @param error_function {function}
   * @param data {string}
   */
    ajax_action(action, method, success_function, error_function, data = '') {
        console.log('ajax action');
        if(typeof data === "object" ){
          data._token = app.csrf_token;
        }else{
          data += `&_token=${app.csrf_token}`;
        }
        if(method.toUpperCase() !== 'GET' && method.toUpperCase() !== 'POST'){
          if(typeof data === "object" ){
            data._method = method;
          }else{
            data += `&_method=${method}`;
          }
          method = 'POST';
        }

        $.ajax({
            url: action,
            method: method,
            data: data,
            success: function(data) {
                if (data.redirect !== undefined) {
                    //this.addSpinner('formsendHover', 'form-loading');
                    window.location.replace(data.redirect);
                    return;
                }
                success_function(data);
            },
            error: function(data) {
                error_function(data);
            }
        })
    },
    languageSettings:{
      en:{
        error: 'Error',
        success: 'Done',
        modalConfirmTtl: 'Confirm removal',
        modalConfirmTtlDefault: 'Confirm',
        modalConfirmCnt: 'The object will be deleted',
        modalConfirmCntDefault: 'Are you sure?',
        modalConfirmBtnTxt: 'Remove',
        modalConfirmBtnTxtDefault: 'Yes',
        modalConfirmBtnCancelTxt : 'Cancel',
        modalConfirmBtnCancelTxtDefault : 'No',
        calendarOption1: 'Last 7 days',
        calendarOption2: 'Last 14 days',
        calendarOption3: 'Last 30 days',
        calendarOption4: 'Last 90 days',
        calendarOption5: 'Last 365 days',
        calendarOption6: 'This month',
        calendarToday: 'Go to today',
        calendarClear: 'Clear date',
        calendarClose: 'Close',
        calendarSelectMonth: 'Select Month',
        calendarPrevMonth: 'Previous Month',
        calendarNextMonth: 'Next Month',
        calendarSelectYear: 'Select Year',
        calendarPrevYear: 'Previous Year',
        calendarNextYear: 'Next Year',
        calendarSelectDecade: 'Select Decade',
        calendarPrevDecade: 'Previous Decade',
        calendarNextDecade: 'Next Decade',
        calendarPrevCentury: 'Previous Century',
        calendarNextCentury: 'Next Century'
      },

      ru:{
          error: 'Ошибка',
          success: 'Данные успешно сохранены',
          modalConfirmTtl: 'Подтвердите удаление',
          modalConfirmTtlDefault: 'Confirm',
          modalConfirmCnt: 'Объект будет удален',
          modalConfirmCntDefault: 'Вы уверены?',
          modalConfirmBtnTxt: 'Удалить',
          modalConfirmBtnTxtDefault: 'Да',
          modalConfirmBtnCancelTxt: 'Отмена',
          modalConfirmBtnCancelTxtDefault: 'Нет',
          calendarOption1: 'Последние 7 дней',
          calendarOption2: 'Последние 14 дней',
          calendarOption3: 'Последние 30 дней',
          calendarOption4: 'Последние 90 дней',
          calendarOption5: 'Последние 365 дней',
          calendarOption6: 'Этот месяц',
          calendarToday: 'Перейти к текущему дню',
          calendarClear: 'Очистить поле даты',
          calendarClose: 'Закрыть',
          calendarSelectMonth: 'Выбрать месяц',
          calendarPrevMonth: 'Предыдущий месяц',
          calendarNextMonth: 'Следующий месяц',
          calendarSelectYear: 'Выбрать год',
          calendarPrevYear: 'Предыдущий год',
          calendarNextYear: 'Следующий год',
          calendarSelectDecade: 'Выберите десятилетие',
          calendarPrevDecade: 'Предыдущее десятилетие',
          calendarNextDecade: 'Следующее десятилетие',
          calendarPrevCentury: 'Предыдущее столетие',
          calendarNextCentury: 'Следующее столетие'
      },

      //for Biuronet
      pl:{
        error: 'Błąd',
        success: 'Gotowy',
        modalConfirmTtl: 'Obiekt zostanie usunięty',
        modalConfirmCnt: 'Jesteś pewny?',
        modalConfirmBtnTxt: 'Usuń',
        modalConfirmBtnCancelTxt : 'Anuluj',
        calendarOption1: 'Ostatnie 7 dni',
        calendarOption2: 'Ostatnie 14 dni',
        calendarOption3: 'Ostatnie 30 dni',
        calendarOption4: 'Ostatnie 90 dni',
        calendarOption5: 'Ostatnie 365 dni',
        calendarOption6: 'Ten miesiąc'
      }
    },
    /**
     * @returns {Object} translation dictionary
     */
    getTranslate(locale){
      let translate = this.languageSettings[locale] === undefined ? this.languageSettings['en'] : this.languageSettings[locale]
      return translate;
    }
};
