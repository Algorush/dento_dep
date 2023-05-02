$( document ).ready(function() {
    let projectApp = new App();
    projectApp.init();
});

     
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


class App{
    // Define global visible variable inside app 
    constructor(){}
    init(){
     
 //new Slider('.owl-carousel');
 // new Sendform(/*selector*/)
 // new MfPopup(/*selector*/);
 // new AjaxPopup(/*selector*/);
 // new MagicPopup(/*selector*/);
 // new Filter({});
    }
};