<div>
    <div class="card card-default color-palette-box">
        {!! $barangTable->table() !!}
    </div>

    @push('js')
    {!! $barangTable->scripts() !!}
    @endpush
</div>
