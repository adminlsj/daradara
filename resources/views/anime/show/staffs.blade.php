<div id="staffs">
    <div class="staffs-wrap flex-row">
        @foreach ($staffs as $staff)
            @include('anime.show.staff')
        @endforeach
    </div>
</div>