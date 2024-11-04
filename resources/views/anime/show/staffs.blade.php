<div id="staffs" class="tabcontent" style="display:none">
    <div class="staffs-wrap flex-row">
        @foreach ($staffs as $staff)
            <div class="staffs-card">
                <a href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->name_en]) }}"><img src="{{ $staff->photo_cover }}" alt="{{ $staff->name_en }}"></a>
                <div class="staffs-name">
                    <a href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->name_en]) }}">{{ $staff->name_en }}</a>
                    <p>{{ $staff->pivot->role }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>