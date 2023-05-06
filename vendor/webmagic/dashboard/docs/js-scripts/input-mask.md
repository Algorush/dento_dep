This functionality is used to set a mask for inputs. [Documentation](https://github.com/RobinHerbots/Inputmask) and 
[Examples Regular Expression](https://regexlib.com/(X(1)A(ApZWRlpJ3jQWMi2OfBgk8Zahh_c6U9fp-AjJkPswmMaDrmLbPTZ0BBo23Uik2C15ZjKT1_kK4i6Aze1gj3BsW9SoGg72GChRcvRVLztYEw4mBxnJmQwWnu3_n0BEPGO2XccUIYV3bHyIfZuruNqHJiAnYOz4VRDpK0qlU9YBixoW2ZhC12_3caGSqWmlFjHh0))/Search.aspx?k=time&AspxAutoDetectCookieSupport=1).

### How to use

Set the input to the class **```'.js_set-mask'```** and attribute **```type="text"```**.

For the input, you need to set the data attributes:

* **data-regex** - _required attribute_, accepts a regular expression for the mask;
* **data-mask** - _required attribute_, shows the format for entering data, if the mask hint is not needed or the one 
added by the regular expression is enough, then we leave the attribute empty;
* **placeholder** - _optional attribute_, regular html placeholder, there are data formats that do not have hints from 
a mask or regular, so you can set a placeholder to show which data format needs to be entered.

##### Examples of setting masks with regular expression:
```html
<div class="form-group">
    <input type="text" class="form-control js_set-mask"

           {{-- for number --}}
           data-mask=""
           data-regex="[0-9]*"
           placeholder="0"
           {{-- end for number --}}

           {{-- for email --}}
           {{--data-mask="_"
           data-regex="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,})$"--}}
           {{-- end for email --}}

           {{-- for number with two decimal places --}}
           {{--data-mask="0"
           data-regex="([0-9]*)(\.[0-9]{2})"--}}
           {{-- end for number with two decimal places --}}

           {{-- for european date and time 24h format --}}
           {{--data-mask="dd/mm/yyyy hh:mm:ss"
           data-regex="([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4} (([01][0-9])|(2[0-3])):[0-5][0-9]:[0-5][0-9]"--}}
           {{-- end for european date and time 24h format --}}

           {{-- for date USA and time 12h format --}}
           {{--data-mask="mm/dd/yyyy hh:mm:ss TT"
           data-regex="((0)[0-9])|((1)[0-2])/([0-2][0-9]|(3)[0-1])/[0-9]{4} ((1[0-2]|0?[1-9]):([0-5][0-9]):([0-5][0-9]) ? ([AaPp][Mm]))"--}}
           {{-- end for date USA and time 12h format --}}

           {{-- for time 12h format --}}
           {{--data-mask="hh:mm:ss TT"
           data-regex="((1[0-2]|0?[1-9]):([0-5][0-9]):([0-5][0-9]) ? ([AaPp][Mm]))"--}}
           {{-- end for timee 12h format --}}

           {{-- for time 24h format --}}
           {{--data-mask="HH:mm:ss"
           data-regex="^(([01][0-9])|(2[0-3])):[0-5][0-9]:[0-5][0-9]$"--}}
           {{-- end for timee 24h format --}}

           {{-- for USA date format --}}
           {{--data-mask="mm/dd/yyyy"
           data-regex="^(((0)[0-9])|((1)[0-2]))(\/)([0-2][0-9]|(3)[0-1])(\/)\d{4}$"--}}
           {{-- end for USA date format --}}

           {{-- for european date format --}}
           {{--data-mask="dd/mm/yyyy"
           data-regex="^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$"--}}
           {{-- end for european date format --}}>
</div>
```
