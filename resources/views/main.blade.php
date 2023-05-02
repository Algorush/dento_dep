@extends('core.base')

@section('content')
    <div id="canvas" class="hide">
        <button class="add" onClick="showDiv()">Details</button>
        {{--Top navigation--}}
        <div class="controls-up">
            <a class="btn-up eye" id="up" >
                <svg xmlns="http://www.w3.org/2000/svg" width="120%" height="80%" viewBox="0 0 60 35">
                    <g data-name="Grupo 1534">
                        <path class="fill" data-name="Trazado 2499" d="M6.713 7.19C2.934 11.49-.012 17.837 0 27.162a6.658 6.658 0 006.437 6.486 6.581 6.581 0 007.11-6.3 20.145 20.145 0 012.681-10.772 7.851 7.851 0 0113.19.009 20.087 20.087 0 012.681 10.636 6.644 6.644 0 006.56 6.431 6.571 6.571 0 006.986-6.307c0-9.946-3.21-16.51-7.221-20.831-8.373-9.022-23.602-8.556-31.711.676z" fill="#037cdb" opacity=".9"/>
                        <g data-name="Grupo 1522" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round">
                            <path data-name="Trazado 2500" d="M21.398 9.998c1.3-.328 1.546-3.428 1.1-5.066-.492-1.793-5.432-.346-4.991 1.338.329 1.272 2.388 4.105 3.891 3.728z"/>
                            <path data-name="Trazado 2501" d="M16.742 11.396c.921-.527.447-3.217-.243-4.528-.756-1.435-4.209.738-3.516 2.09.524 1.021 2.695 3.046 3.759 2.438z"/>
                            <path data-name="Trazado 2502" d="M14.086 14.287c.679-1.045-.7-3.362-2.129-4.36-.8-.558-1.638.532-2.6 1.064-1.03.57-.628 2.55.083 3.059 1.096.786 3.862 1.443 4.646.237z"/>
                            <path data-name="Trazado 2503" d="M11.898 19.427c.65-1.72-.838-4.027-2.432-4.726-1.659-.728-2.733.4-3.531 1.157-1.022.968.3 3.719 1.055 4.156 1.167.674 4.398.759 4.908-.587z"/>
                            <path data-name="Trazado 2504" d="M8.039 20.49a14.307 14.307 0 00-2.477-.37 3.342 3.342 0 00-2.684 3.146 14.179 14.179 0 00.451 3.22 3.69 3.69 0 003.052 2.3h.067a4.423 4.423 0 004.131-2.368 3.516 3.516 0 00.238-.561l.107-.341a4.107 4.107 0 00.166-1.822 2.045 2.045 0 00-.241-.763c-.378-.599-1.812-2.237-2.81-2.441z"/>
                            <path data-name="Trazado 2505" d="M25.04 9.998c-1.3-.328-1.546-3.428-1.1-5.066.492-1.793 5.432-.346 4.992 1.338-.331 1.272-2.389 4.105-3.892 3.728z"/>
                            <path data-name="Trazado 2506" d="M29.695 11.396c-.921-.527-.447-3.217.243-4.528.756-1.435 4.21.738 3.517 2.09-.524 1.021-2.693 3.046-3.76 2.438z"/>
                            <path data-name="Trazado 2507" d="M32.352 14.287c-.68-1.045.7-3.362 2.129-4.36.8-.558 1.637.532 2.6 1.064 1.03.57.628 2.55-.083 3.059-1.096.786-3.861 1.443-4.646.237z"/>
                            <path data-name="Trazado 2508" d="M34.539 19.427c-.651-1.72.838-4.027 2.431-4.726 1.659-.728 2.734.4 3.531 1.157 1.023.968-.3 3.719-1.054 4.156-1.167.674-4.399.759-4.908-.587z"/>
                            <path data-name="Trazado 2509" d="M38.399 20.49a14.308 14.308 0 012.476-.37 3.342 3.342 0 012.683 3.146 14.155 14.155 0 01-.45 3.22 3.692 3.692 0 01-3.052 2.3h-.066a4.425 4.425 0 01-4.129-2.368 3.591 3.591 0 01-.237-.561l-.107-.341a4.12 4.12 0 01-.167-1.822 2.046 2.046 0 01.242-.763c.369-.599 1.809-2.237 2.807-2.441z"/>
                        </g>
                        <path data-name="Trazado 2510" d="M7.232 21.584a2.79 2.79 0 01-2.786 1.963" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2511" d="M6.444 27.194A2.791 2.791 0 019.23 25.23" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2512" d="M4.446 25.927s3.052-2.634 4.785-2.079" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2513" d="M7.457 17.977s1.627-1.4 2.551-1.109" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2514" d="M39.23 21.584a2.791 2.791 0 002.786 1.963" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2515" d="M40.019 27.194a2.792 2.792 0 00-2.786-1.964" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2516" d="M42.017 25.927s-3.052-2.634-4.784-2.079" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                        <path data-name="Trazado 2517" d="M39.005 17.977s-1.627-1.4-2.551-1.109" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                    </g>
                </svg>
            </a>
            <a class="btn-up" id="front" >
                <svg xmlns="http://www.w3.org/2000/svg" width="110%" height="80%" viewBox="0 0 50 30">
                    <g id="Grupo_1532" data-name="Grupo 1532" transform="translate(0.5 0)">
                        <path id="Trazado_2450" data-name="Trazado 2450" d="M277.571,438.638c1.208,16.111-15.241,12.517-20.959,12.455h-.4c-5.719.063-21.352,3.843-20.959-12.455l6.13,2.7h30.038Z" transform="translate(-234.608 -421.574)" fill="#324858" class="fill"/>
                        <path id="Trazado_2451" data-name="Trazado 2451" d="M277.569,426.354c.7-10.864-15.241-6.858-20.959-6.8a.71.71,0,0,1-.4,0c-5.718-.063-21.664-4.068-20.959,6.8l1.846,2.628h38.666Z" transform="translate(-234.605 -418.786)" fill="#324858" class="fill"/>
                        <path id="Trazado_2452" data-name="Trazado 2452" d="M259.871,439.605" transform="translate(-238.065 -421.709)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2453" data-name="Trazado 2453" d="M236.314,427.643s-1.839-.591-1.811,2.189c.027,2.727,1.811,2.163,1.811,2.163" transform="translate(-234.503 -420.022)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2454" data-name="Trazado 2454" d="M236.639,439.739s-1.381,0-1.381-1.96c0-1.608.522-2.284,1.64-2.644a1.848,1.848,0,0,1,2.052.765" transform="translate(-234.609 -421.072)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2455" data-name="Trazado 2455" d="M236.87,439.645" transform="translate(-234.835 -421.715)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2456" data-name="Trazado 2456" d="M238.347,441.209s-1.579.272-1.478-2.069,1.279-2.921,2.086-3.06a1.544,1.544,0,0,1,1.767.864" transform="translate(-234.834 -421.21)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2457" data-name="Trazado 2457" d="M240.312,443.082s-2.021.274-1.829-3.662a2.106,2.106,0,0,1,.819-1.57l.242-.184a2.07,2.07,0,0,1,2.948.427c.048.069.072.111.072.111" transform="translate(-235.06 -421.377)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2458" data-name="Trazado 2458" d="M244.624,439.431a2.18,2.18,0,0,0-3.014-.787c-2.126.936-1.147,6.674.279,6.384a2.75,2.75,0,0,0,1.98-1.373" transform="translate(-235.328 -421.535)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2459" data-name="Trazado 2459" d="M248.6,440.714s-1.75-2.629-3.573-1.055c-1.612,1.391-.363,8.519,1.821,7.311a3.775,3.775,0,0,0,2.006-2.366" transform="translate(-235.878 -421.646)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2460" data-name="Trazado 2460" d="M253.778,441.432a.89.89,0,0,0-.609-1,10.365,10.365,0,0,0-3.335-.019c-.438.064-.64.5-.64.978,0,3.123.608,4.392,1.192,5.242a1.661,1.661,0,0,0,2.623.153,5.285,5.285,0,0,0,.956-2.679" transform="translate(-236.565 -421.806)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2461" data-name="Trazado 2461" d="M255.168,440.417c-.438.064-.64.5-.64.978,0,3.123.61,4.758,1.195,5.608a1.285,1.285,0,0,0,2.119,0c.573-.847,1.183-2.47,1.271-5.569a.889.889,0,0,0-.609-1A10.365,10.365,0,0,0,255.168,440.417Z" transform="translate(-237.314 -421.806)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2462" data-name="Trazado 2462" d="M238.413,427.517s-1.7-.873-1.986.4-.337,4.4.8,4.852a1.693,1.693,0,0,0,1.19-.046" transform="translate(-234.748 -419.971)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2463" data-name="Trazado 2463" d="M241,427.266s-1.515-1.049-2.194,0-.652,5.523.373,6.068c.606.321,1.665-.418,1.665-.418" transform="translate(-235.042 -419.911)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2464" data-name="Trazado 2464" d="M244.9,428.4a3.076,3.076,0,0,0-1.759-1.821,1.562,1.562,0,0,0-2.035,1.221,9.593,9.593,0,0,0,.593,6.287c.911,1.565,2.868-.3,2.868-.3" transform="translate(-235.393 -419.87)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2465" data-name="Trazado 2465" d="M250.478,429.3c-.791-2.662-2.809-3.909-4.072-2.756-1.235,1.129-1.466,4.893-1.289,6.611a2.267,2.267,0,0,0,.935,1.505c1.211,1.01,3.83.045,3.83.045" transform="translate(-235.986 -419.816)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2466" data-name="Trazado 2466" d="M254.605,436.305a8.075,8.075,0,0,0,2.916-.518,1.83,1.83,0,0,0,1.08-1.686c-.027-9.052-3.846-8.733-3.846-8.733s-3.81-.424-4.084,8.624a1.828,1.828,0,0,0,1.033,1.714,8.069,8.069,0,0,0,2.9.6" transform="translate(-236.773 -419.71)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2467" data-name="Trazado 2467" d="M283.182,427.643s1.839-.591,1.811,2.189c-.027,2.727-1.811,2.163-1.811,2.163" transform="translate(-241.338 -420.022)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2468" data-name="Trazado 2468" d="M282.55,439.739s1.381,0,1.381-1.96c0-1.608-.522-2.284-1.64-2.644a1.848,1.848,0,0,0-2.052.765" transform="translate(-240.924 -421.072)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2469" data-name="Trazado 2469" d="M282.922,439.645" transform="translate(-241.301 -421.715)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2470" data-name="Trazado 2470" d="M280.815,441.209s1.579.272,1.478-2.069-1.279-2.921-2.085-3.06a1.544,1.544,0,0,0-1.768.864" transform="translate(-240.672 -421.21)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2471" data-name="Trazado 2471" d="M278.811,443.082s2.021.274,1.829-3.662a2.106,2.106,0,0,0-.819-1.57l-.242-.184a2.07,2.07,0,0,0-2.948.427c-.048.069-.072.111-.072.111" transform="translate(-240.408 -421.377)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2472" data-name="Trazado 2472" d="M274.474,439.431a2.18,2.18,0,0,1,3.014-.787c2.126.936,1.147,6.674-.279,6.384a2.75,2.75,0,0,1-1.98-1.373" transform="translate(-240.115 -421.535)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2473" data-name="Trazado 2473" d="M270.446,440.714s1.75-2.629,3.573-1.055c1.612,1.391.363,8.519-1.821,7.311a3.775,3.775,0,0,1-2.006-2.366" transform="translate(-239.514 -421.646)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2474" data-name="Trazado 2474" d="M265.235,441.432a.89.89,0,0,1,.609-1,10.365,10.365,0,0,1,3.335-.019c.438.064.64.5.64.978,0,3.123-.608,4.392-1.192,5.242a1.661,1.661,0,0,1-2.623.153,5.284,5.284,0,0,1-.956-2.679" transform="translate(-238.792 -421.806)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2475" data-name="Trazado 2475" d="M263.876,440.417c.438.064.64.5.64.978,0,3.123-.61,4.758-1.195,5.608a1.285,1.285,0,0,1-2.119,0c-.572-.847-1.183-2.47-1.27-5.569a.89.89,0,0,1,.609-1A10.365,10.365,0,0,1,263.876,440.417Z" transform="translate(-238.073 -421.806)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2476" data-name="Trazado 2476" d="M281.026,427.517s1.7-.873,1.986.4.337,4.4-.8,4.852a1.693,1.693,0,0,1-1.19-.046" transform="translate(-241.035 -419.971)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2477" data-name="Trazado 2477" d="M278.358,427.266s1.515-1.049,2.194,0,.652,5.523-.373,6.068c-.606.321-1.665-.418-1.665-.418" transform="translate(-240.66 -419.911)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2478" data-name="Trazado 2478" d="M274.228,428.4a3.076,3.076,0,0,1,1.759-1.821,1.562,1.562,0,0,1,2.035,1.221,9.594,9.594,0,0,1-.593,6.287c-.911,1.565-2.868-.3-2.868-.3" transform="translate(-240.08 -419.87)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2479" data-name="Trazado 2479" d="M268.43,429.3c.791-2.662,2.809-3.909,4.072-2.756,1.235,1.129,1.466,4.893,1.289,6.611a2.267,2.267,0,0,1-.935,1.505c-1.211,1.01-3.83.045-3.83.045" transform="translate(-239.266 -419.816)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                        <path id="Trazado_2480" data-name="Trazado 2480" d="M263.892,436.305a8.079,8.079,0,0,1-2.917-.518,1.83,1.83,0,0,1-1.08-1.686c.027-9.052,3.846-8.733,3.846-8.733s3.81-.424,4.084,8.624a1.829,1.829,0,0,1-1.033,1.714,8.066,8.066,0,0,1-2.9.6" transform="translate(-238.068 -419.71)" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                    </g>
                </svg>
            </a>
            <a class="btn-up eye" id="low" >
                <svg xmlns="http://www.w3.org/2000/svg" width="120%" height="80%" viewBox="0 0 60 35">
                    <g data-name="Grupo 1536">
                        <path class="fill" data-name="Trazado 2536" d="M38.06 27.162c3.695-4.416 6.574-10.927 6.563-20.5A6.684 6.684 0 0038.331.005a6.558 6.558 0 00-6.949 6.468 21.473 21.473 0 01-2.627 11.052 7.479 7.479 0 01-12.892-.009 21.413 21.413 0 01-2.621-10.915 6.659 6.659 0 00-6.413-6.6A6.555 6.555 0 000 6.474c0 10.208 3.137 16.945 7.06 21.38 8.188 9.262 23.074 8.783 31-.692z" fill="#037cdb" opacity=".9"/>
                        <path data-name="Trazado 2537" d="M20.913 26.182s-.741-.742-1.579.258-2.095 3.223-1.547 4.254 2.617 1.136 3.086.805.782-.838.782-2.482a4.343 4.343 0 00-.742-2.835z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2538" d="M16.112 25.086s-1.579-.258-3 2.224 2.031 3.932 3.277 2.482c.538-.625 1.431-4.352-.277-4.706z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/>
                        <path data-name="Trazado 2539" d="M13.218 24.171a1.2 1.2 0 00-.979-.98 4.786 4.786 0 00-3.952.516c-1.87 1.45 2.12 5.44 3.505 4.344a4.377 4.377 0 001.426-3.88z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2540" d="M23.709 26.182s.741-.742 1.579.258 2.095 3.223 1.547 4.254-2.617 1.136-3.086.805-.781-.838-.781-2.482a4.345 4.345 0 01.741-2.835z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2541" d="M28.512 25.086s1.579-.258 3 2.224-2.03 3.932-3.277 2.482c-.539-.625-1.432-4.352.277-4.706z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2542" d="M31.405 24.171a1.2 1.2 0 01.979-.98 4.786 4.786 0 013.952.516c1.87 1.45-2.12 5.44-3.505 4.344a4.377 4.377 0 01-1.426-3.88z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2543" d="M36.297 13.711a3.964 3.964 0 012.466.725c1.131.841.145 1.827.435 2.9s.754 3.916-1.015 4.989-3.364.871-4.09 0a3.933 3.933 0 01-.435-3.771c.522-1.363-.319-2.495.435-3.8a2.187 2.187 0 012.204-1.043z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2544" d="M37.523 4.008a4.756 4.756 0 012.519.794 3.7 3.7 0 011.4 2.575c.274 1.013-.411 4.465-2.081 5.478a3.477 3.477 0 01-4.24-.242 3.954 3.954 0 01-.576-3.675c.493-1.288-.142-2.465.57-3.7a2.994 2.994 0 012.408-1.23z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2545" d="M36.422 15.828a10.983 10.983 0 010 4.845" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2546" d="M38.412 16.998a6.261 6.261 0 01-1.742.264" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2547" d="M34.951 17.909a6.293 6.293 0 001.76-.066" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2548" d="M37.769 6.501a18.54 18.54 0 01-.328 5.177" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2549" d="M35.637 8.761a11.071 11.071 0 013.988.328" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2550" d="M8.332 13.711a3.962 3.962 0 00-2.465.725c-1.131.841-.145 1.827-.435 2.9s-.755 3.916 1.015 4.989 3.364.871 4.09 0a3.937 3.937 0 00.435-3.771c-.523-1.363.319-2.495-.435-3.8a2.189 2.189 0 00-2.205-1.043z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2551" d="M7.103 4.008a4.759 4.759 0 00-2.52.794 3.711 3.711 0 00-1.4 2.575c-.274 1.013.411 4.465 2.082 5.478a3.477 3.477 0 004.24-.242 3.954 3.954 0 00.575-3.675c-.493-1.288.143-2.465-.57-3.7a2.991 2.991 0 00-2.407-1.23z" fill="#fff" stroke="#324858" stroke-linecap="round" stroke-linejoin="round"/><path data-name="Trazado 2552" d="M8.203 15.828a10.984 10.984 0 000 4.845" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2553" d="M6.213 16.998a6.26 6.26 0 001.742.264" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2554" d="M9.674 17.909a6.293 6.293 0 01-1.76-.066" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2555" d="M6.856 6.501a18.519 18.519 0 00.329 5.177" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/><path data-name="Trazado 2556" d="M9.101 8.761a12.334 12.334 0 00-4.213.328" fill="none" stroke="#324858" stroke-linecap="round" stroke-linejoin="round" stroke-width=".5"/>
                    </g>
                </svg>
            </a>
        </div>
        {{--End top navigation--}}
        <div class="btns-up">
            <a id="attach" src=""></a>
            <a id="grid" src=""></a>
            @if(isset($styles['ipr']))  
            <a id="IPR-show" src=""></a>
            @endif
            <a id="reset" src=""></a>
        </div>        
        <div class="controls">


            <div class="half">        	
                <div class="nmbr"><span id="step-upper">0</span> of <span id="step-upper-total"></span></div>
                <div class="nmbr">Upper Aligners</div>
            </div>
            <div class="half">
                <div class="nmbr"><span id="step-lower">0</span> of <span id="step-lower-total"></span></div>        	
                <div class="nmbr">Lower Aligners</div>
            </div>
            <div class="dvd">
                <svg class="m-auto start disabled" viewBox="0 0 15.079 15.932" width="15.079" height="15.932">
                    <path fill="#037cdb" transform="translate(15.079 15.933) rotate(180)" d="M 0 14.639 V 1.292 A 1.3 1.3 0 0 1 2.014 0.218 L 12.054 6.9 a 1.274 1.274 0 0 1 0.17 0.136 V 1.427 a 1.427 1.427 0 0 1 2.855 0 V 14.274 a 1.427 1.427 0 1 1 -2.855 0 V 8.9 a 1.233 1.233 0 0 1 -0.17 0.132 L 2.014 15.713 A 1.293 1.293 0 0 1 0 14.639 Z"></path>
                </svg>
                <svg class="m-auto back disabled" viewBox="0 0 23.507 15.932" width="23.507" height="15.932">
                    <path fill="#037cdb" transform="translate(23.507 15.932) rotate(180)" d="M 10.888 14.638 V 9.808 l -8.873 5.9 A 1.294 1.294 0 0 1 0 14.638 V 1.292 A 1.3 1.3 0 0 1 2.015 0.217 l 8.873 5.906 V 1.292 A 1.3 1.3 0 0 1 12.9 0.217 L 22.941 6.9 a 1.287 1.287 0 0 1 0 2.133 L 12.9 15.712 a 1.292 1.292 0 0 1 -2.014 -1.074 Z"></path>
                </svg>
                <svg class="m-auto play" viewBox="0 0 20.423 25.783" width="30.423" height="37.783">
                    <path fill="#037cdb" transform="translate(0 -0.005)" d="M 19.506 11.169 L 3.26 0.357 A 2.1 2.1 0 0 0 0 2.1 v 21.6 a 2.1 2.1 0 0 0 3.26 1.739 L 19.506 14.62 A 2.081 2.081 0 0 0 19.506 11.169 Z"></path>
                </svg>
                <svg class="m-auto next" viewBox="0 0 23.507 15.932" width="23.507" height="15.932">
                    <path fill="#037cdb" transform="translate(0)" d="M 10.888 14.638 V 9.808 l -8.873 5.9 A 1.294 1.294 0 0 1 0 14.638 V 1.292 A 1.3 1.3 0 0 1 2.015 0.217 l 8.873 5.906 V 1.292 A 1.3 1.3 0 0 1 12.9 0.217 L 22.941 6.9 a 1.287 1.287 0 0 1 0 2.133 L 12.9 15.712 a 1.292 1.292 0 0 1 -2.014 -1.074 Z"></path>
                </svg>
                <svg class="m-auto end" viewBox="0 0 15.079 15.932" width="15.079" height="15.932">
                    <path fill="#037cdb" transform="translate(0)" d="M 0 14.639 V 1.292 A 1.3 1.3 0 0 1 2.014 0.218 L 12.054 6.9 a 1.274 1.274 0 0 1 0.17 0.136 V 1.427 a 1.427 1.427 0 0 1 2.855 0 V 14.274 a 1.427 1.427 0 1 1 -2.855 0 V 8.9 a 1.233 1.233 0 0 1 -0.17 0.132 L 2.014 15.713 A 1.293 1.293 0 0 1 0 14.639 Z"></path>
                </svg>
            </div>
        </div>
    </div>
    </div>

@endsection
