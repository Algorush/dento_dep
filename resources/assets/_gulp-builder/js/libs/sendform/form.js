import Field from './field';

/**
 * @param formClass {string} - class of form.
 * @param settings {Object} - settings object.
 * @param reference {Object} - reference for validation.
 */
export default class Form{
    constructor(formClass, settings, reference) {
        this.form = document.querySelector(formClass);
        if(this.form == null || undefined) return;

        this.inputs = Array.from(this.form.querySelectorAll('input:not([type="hidden"]), select'));
        /**
         * Set action(url for request)
         */
        let action = this.form.getAttribute('action');

        this.action = action != null ? action  : '/';

        // Form state if it contain errors
        this.state = true;
        //determine if there are any mistakes now.    
        this.error = false;
        // Show spunner activity
        this.isSpinnerActive = false;
        // Text of status field.
        this.statusText = null;
        // Contain all field of this form
        this.items = [];
        // Contain errors field with position
        this.errorItems = {};

        let customSettings = {
            resetAfterSubmit: true,
            onlyValidate: false,
            statusId: 'form-status',
            statusErrorClass:'with_error',
            statusSucssClass : 'with_success',
            errorClass: 'error',
            validateClass: '.js_sendform-validate',
            requiredClass: 'form-required',
            modalOpen: true,
            modalId: '#thanks',
            msgSend: 'Sending data',
            msgDone: 'Done',
            msgError: 'Sending error',
            msgValError: 'One of required field is empty',
            spinnerColor: '#000',
            formPosition: 'relative',
            resetClass: '.js_senform-reset',
            method: 'POST',
            success: data => {
                this.successSubmit(data);
            },
            error: data => {
                this.errorSubmit(data);
            },
            validationSuccess : () => {},
            validationError : () => {
                this.validationErrorCallback();
            }
        };

        let customReference = {
            email: ['isEmail', 'isEmpty'],
            text: ['isEmpty'],
            phone: ['minLength'],
            required:['isEmpty'],
            checkbox:['isChecked'],
            radio:['isCheckedRadio']
        };

        this.settings = Object.assign({}, customSettings ,settings);
        this.reference = Object.assign({}, customReference, reference);

        this.onInit();
    }

    /**
     * On initialize class.
     * Creating all inputs of this form.
     * if setting for only validate true init this func.
     * else init function on submitting.
     * creating status text field.
     * init function for reset field.
     */
    onInit(){
        this.createInputsValidate();

        if(this.settings.onlyValidate){
            this.onValidate();
        }
        else{
            this.form.addEventListener('submit', event => {
                event.preventDefault();
                this.preSubmit();
            });
        }
        this.createStatusField();
        this.onReset();
    }

    /**
     * Creating for each input, select, checkboxes own class.
     * And pushing this classes into array.
     */
    createInputsValidate(){
        this.inputs.forEach((el, i)=>{
            let item = new Field(el, this.state, this.reference, this.settings, i);
            this.items.push(item);
        });
    }
    /**
     * Create hidden field for status text.
     */
    createStatusField(){
        var div = document.createElement('div');
        div.innerHTML = '';
        div.id= this.settings.statusId;
        this.form.appendChild(div);
        this.statusText = this.form.querySelector(`#${this.settings.statusId}`);
    }

    /**
     * checking on error.
     * prepare for submitting:
     * add spinner, add status text.
     * call submit function.
     */
    preSubmit(){
        this.validateField();
        if(!this.state){
            this.errorOnForm();
            return;
        }

        this.error = false;
        if(!this.isSpinnerActive) this.addSpinner();
        this.statusText.innerHTML = this.settings.msgSend;
        this.submitData();
    }

    /**
     * Foreach in all items call validation function.
     * @param result {object} - variable keep return from
     * validation function.Object contain 2 attr
     * result.valid {boolean} -show is field pass validation.
     * result.position {string} - position of field.
     *
     */
    validateField(){
        let localState = true;
        this.items.forEach((item)=>{
            let result = item.validate();
            if (result == undefined) return;
            localState = localState * result.valid;

            if(localState){
                delete this.errorItems[result.position];
            }
            else{
                this.errorItems[result.position] = false;
            }
        });

        this.state = localState;
        if(this.state){
            this.removeStatusText();
        }
    }

    /**
     * Call reset method on all items.
     */
    resetField(){
        this.items.forEach((item)=>{
            item.resetSelf();
        });
    }

    /**
     * Adding spinner.
     */
    addSpinner(){
        var div = document.createElement('div');
        div.innerHTML= '<div class="form-loading"></div>';
        div.id= 'formsendHover';
        this.form.appendChild(div);
        this.isSpinnerActive = true;
    }

    /**
     * Removing spinner.
     */
    removeSpinner(){
        if(!document.querySelector('#formsendHover')) return;
        document.querySelector('#formsendHover').remove();
        this.isSpinnerActive = false;
    }

    /**
     * init validation by press on btn.
     */
    onValidate(){
        let validateBtn = this.form.querySelector(this.settings.validateClass);
        validateBtn.addEventListener('click', (event)=>{
            event.preventDefault();
            this.validateField();
            if(this.state){
                this.settings.validationSuccess();
                return;
            }
            this.settings.validationError();
        });
    }

    /**
     * init function reseting by press btn.
     */
    onReset(){
        let resetClass = this.form.querySelector(this.settings.resetClass);
        if(resetClass == null || undefined) return;
        resetClass.addEventListener('click', ()=>{
            this.resetField();
        });
    }

    /**
     * Add text and set error on true.
     * And add text error.
     */
    errorOnForm(){
        if(this.error) return;
        this.error = true;
        this.statusText.innerHTML = this.settings.msgValError;
        this.statusText.classList.add('with_error');
    }

    /**
     * On error
     */
    validationErrorCallback(){
        this.errorStatusText();
        this.printText(this.settings.msgValError);
    }

    /**
     * Change status text
     *
     * @param text
     */
    printText(text){
        this.statusText.innerHTML = text;
    }

    /**
     * Clear status
     */
    removeStatusText(){
        this.statusText.innerHTML = '';
        this.statusText.classList = '';
    }

    /**
     * Add class error on status
     */
    errorStatusText(){
        this.statusText.classList.add(this.settings.statusErrorClass);
    }


    /**
     * Submitting data to server ajax type
     */
    submitData(){

        let request = new XMLHttpRequest();

        request.open(this.settings.method, this.action , true);

        let filesInput = this.form.querySelectorAll('input[type="file"]');

        let data = new FormData(this.form);

        if(filesInput.length) {
            filesInput = Array.from(filesInput);
            data = this.prepareFiles(filesInput, data);
        }

        request.onload = data => {
            if (request.status >= 200 && request.status < 400) {
                // Success!
                this.settings.success(request);
            } else {
                // We reached our target server, but it returned an error
                this.settings.error();
            }
            this.removeSpinner();
        };

        request.send(data);
    }

    /**
     * Check input with files on existing files
     *  run function to prepare files
     *
     * @param inputsWithFile
     * @param data
     * @returns {*}
     */
    prepareFiles(inputsWithFile, data){

        inputsWithFile.forEach((input)=>{
            if(!input.files.length) return;

            data = this.appendFilesIntoData(input, data);
        });

        return data;
    }

    /**
     * Add files into data with new names
     * @param input
     * @param data
     * @returns {*}
     */
    appendFilesIntoData(input, data){

        let files = Array.from(input.files);

        files.forEach((file, i)=>{
            data.append(`${input.name}${i}`, file);
        });

        return data;
    }

    /**
     * On error submit
     */
    errorSubmit(){
        this.errorStatusText();
        this.printText(this.settings.msgError);
    }

    /**
     * On success submit
     * @param data
     */
    successSubmit(data){
        this.printText(this.settings.msgDone);
    }

}