<form class="form-inline js-submit" action="/dashboard/tech/multifields-test">
    {!! csrf_field() !!}

    @php
        $multifield = (new Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsSimpleElement());


    @endphp

        {!! $multifield !!}

    <div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
