<div>
    <strong>{{ $casino->name }}</strong>
    <br>
    {!! implode(",\n<br>\n", explode(", ", $casino->address)) !!}
    <br>
    <br>
    <strong>Opening Hours</strong>
    <br>
    {{ nl2br($casino->hours) }}

    @if (\Auth::guest() ? false : \Auth::user()->isAdmin())
        <br>
        <br>
        <a
            href="/{{ $casino->id }}/edit"
            class="btn btn-warning btn-block text-center"
        >Edit</a>
    @endif
</div>
