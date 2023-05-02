
@push('after-scripts')
    <script>
        $('.js_copy-link').on('click', function(e){
            e.preventDefault();
            console.log($(this).attr('href'))
            var dummy = document.createElement('input'),
                text = $(this).attr('href');

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
        })
    </script>
@endpush

