<div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <img style="width: 25%;" src="{{$application->user->photo ? asset('images/' . $application->user->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt="">
            </div>
            <div class="form-group col-md-6">
                <h3>Batch Details: {{$application->batch->batch_no}}/{{$application->batch->year}}<h3>
                <h3>Tier: Tier-3<h3>
            </div>
            <div class="col-md-4">
                <label for="inputEmail1" class="ul-form__label"><strong>First Name:</strong></label>
                <div>{{$application->user->firstname}} </div>
            </div>

            <div class="col-md-4">
                <label for="inputEmail1" class="ul-form__label"><strong>Last Name:</strong></label>
                <div>{{$application->user->lastname}}</div>
            </div>

            <div class="col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Address:</strong></label>
                <div>{{$application->user->address}} </div>
            </div>

            <div class="col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                <div>{{$application->user->user_state->name}} </div>
            </div>

            <div class="col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong> </label>
                <div>{{$application->user->user_lga->name}}</div>
            </div>
        </div>

        <div class="custom-separator"></div>

        <h4>Uploaded Documents</h4>
        <div class="custom-separator"></div>
        <div class="row">
            <div class="col-md-4">
                <label for="inputEmail5" class="ul-form__label">Birth Certificate or Declaration of Age:</label>
                <br /><a href="{{ route('download-meptp-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=birth_certificate" class="btn btn-info">DOWNLOAD DOCUMENT</a>
            </div>
            <div class="col-md-4">
                <label for="inputEmail5" class="ul-form__label">Educational Credentials:</label>
                <br /><a href="{{ route('download-meptp-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=educational_certificate" class="btn btn-info">DOWNLOAD DOCUMENT</a>
            </div>
            <div class="col-md-4">
                <label for="inputEmail5" class="ul-form__label">Health Related Academic Training
                    Credentials:</label>
                <br /><a href="{{ route('download-meptp-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=academic_certificate" class="btn btn-info">DOWNLOAD DOCUMENT</a>
            </div>
        </div>

        <div class="custom-separator"></div>

        <h4>Patent Medicine Vendor Shop</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Name:</strong></label>
                <div>{{$application->shop_name}}</div>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Phone:</strong></label>
                <div>{{$application->shop_phone}}</div>
            </div>

            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Email:</strong></label>
                <div>{{$application->shop_email}}</div>
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Address:</strong></label>
                <div> {{$application->shop_address}}
                </div>
            </div>

            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>Town/City:</strong></label>
                <div>{{$application->city}}</div>
            </div>

            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                <div>{{$application->user_state->name}}</div>
            </div>

            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong></label>
                <div>{{$application->user_lga->name}}</div>
            </div>

            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Are you registered?</strong> </label>
                <div>{{$application->is_registered ? 'Yes' : 'No'}}</div>
            </div>

            @if($application->is_registered)
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>PPMVL Number :</strong></label>
                <div>{{$application->ppmvl_no}}</div>
            </div>
            @endif
        </div>

        <div class="custom-separator"></div>

        <h4>Training Centre</h4>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Preferred Training Centre</strong></label>
                <div class="input-right-icon">{{$application->school->name}}</div>
            </div>
        </div>
    </div>

    @if(Auth::user()->hasRole(['state_office']))
    <div class="card-footer">
        <div class="mc-footer">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('meptp-pending-approve') }}?application_id={{$application->id}}&batch_id={{$application->batch_id}}&school_id={{$application->traing_centre}}&vendor_id={{$application->user->id}}" class="btn  btn-primary m-1" id="save" name="save">Approve</a>
                    <button data-toggle="modal" data-target="#queryModal" type="button" class="btn  btn-danger m-1" id="query" name="query">Query</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="quriedForm" class="w-100" method="POST" action="{{ route('meptp-pending-query') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Quired Reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="application_id" value="{{$application->id}}">
            <input type="hidden" name="batch_id" value="{{$application->batch_id}}">
            <input type="hidden" name="school_id" value="{{$application->traing_centre}}">
            <input type="hidden" name="vendor_id" value="{{$application->vendor_id}}">
            <label for="query1">Describe Reason</label>
            <textarea rows="3" name="query" class="form-control @error('query') is-invalid @enderror" id="query1" type="text" placeholder="Enter your first name" required>
            </textarea>
            @error('query')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button onclick="submitReject(event)" type="button" class="btn btn-primary">Submit & Reject</button>
        </div>
        </div>
        </form>
    </div>
    </div>

    <script>
        function submitReject(event){
            event.preventDefault();

            $.confirm({
                title: 'Quired & Reject',
                content: 'Are you sure want to reject this application?',
                buttons: {   
                    ok: {
                        text: "YES",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function(){
                            document.getElementById('quriedForm').submit();
                        }
                    },
                    cancel: function(){
                            console.log('the user clicked cancel');
                    }
                }
            });

        }
    </script>
    @endif
</div>

