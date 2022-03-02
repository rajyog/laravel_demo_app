@php
    $inquiryStatus=getInquiryStatus();
@endphp
<div class="d-flex flex-wrap gap-2 userscomman">
    @foreach($inquiryStatus as $key=>$value)
        @if($key > 0)
            <a href="#" class="btn btn-outline-primary waves-effect waves-light">{{$value['name']}}</a>
        @endif
    @endforeach
</div>