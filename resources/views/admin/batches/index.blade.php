@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Batches Management', 'route' => 'batches.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h2 class=" mb-6">MEPTP Batches Management</h2>
        <hr>
        <a href="{{route('batches.create')}}"><button class="btn btn-primary" type="button">ADD NEW BATCH</button></a>
        <hr>
        @if(!$batches->isEmpty())
        <div class="row">
            @foreach($batches as $batch)
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="card card-icon mb-4">
                    <a href="admin-batch-mgt.php">
                        <div class="card-body text-center"><i class="i-Students"></i>
                            <p class="text-muted mt-2 mb-2">Batch Number</p>
                            <p class="text-primary text-40 line-height-1 m-0">{{$batch->year}}</p>
                            <p><span class="badge badge-pill badge-outline-success p-2 m-1">ACTIVE</span></p>
                            <p><span class="badge badge-success w-badge">12-May-2021</span></p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="card card-icon mb-4">
                    <a href="admin-batch-mgt.php">
                        <div class="card-body text-center"><i class="i-Students"></i>
                            <p class="text-muted mt-2 mb-2">Batch Number</p>
                            <p class="text-primary text-40 line-height-1 m-0">2021</p>
                            <p><span class="badge badge-pill badge-outline-success p-2 m-1">ACTIVE</span></p>
                            <p><span class="badge badge-success w-badge">12-May-2021</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Students"></i>
                        <p class="text-muted mt-2 mb-2">Batch Number</p>
                        <p class="text-primary text-40 line-height-1 m-0">2019</p>
                        <p><span class="badge badge-pill badge-outline-danger p-2 m-1">CLOSED</span></p>
                        <p><span class="badge badge-danger w-badge">12-May-2021</span></p>
                    </div>
                </div>
            </div> -->
            @endforeach
        </div>
        {{$batches->links('pagination')}}
        @else
        <span>No batches found</span>
        @endif
    </div>
</div>
<script type="text/javascript">
function setPerPage(sel) {
    var url_string = window.location.href
    var new_url = new URL(url_string);
    let queryParams = (new_url).searchParams;
    var url_page = new_url.searchParams.get("page");

    var page = sel.value;
    var mParams = "?";
    if (queryParams != '') {
        mParams += queryParams + '&';
    }
    if (url_page !== null) {
        nParams = location.protocol + '//' + location.host + location.pathname + "?" + queryParams;
        var href = new URL(nParams);
        href.searchParams.set('page', page);
        window.location.href = href;
    } else {
        mParams += 'page=' + page;
        var new_url = location.protocol + '//' + location.host + location.pathname + mParams;
        window.location.href = new_url;
    }
}
</script>
@endsection