@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Status', 'route' => 'meptp-application-status'])
<div class="row">
    <div class="col-lg-12 col-md-12">

        <!--begin::form-->


        <div class="card-body">
            <h4>MEPTP Application Status - Vendor Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-card alert-warning" role="alert">APPLICATION FOR MEPTP (Batch: 1/2021)
                        STATUS: Document Verification Pending</div>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-card alert-danger" role="alert">
                        <p>APPLICATION FOR MEPTP (Batch: 1/2021) STATUS: Document Verification Queried</p>
                        <p><strong>REASONS: </strong></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean feugiat, nulla ut dictum
                            varius, arcu libero interdum quam, vel ullamcorper odio est vitae lacus.</p>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">APPLICATION FOR MEPTP (Batch: 1/2021)
                        STATUS: Application Approved</div>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-card alert-success" role="alert">APPLICATION FOR MEPTP (Batch: 1/2021)
                        STATUS: Application Approved and Examination Card Generated
                        <button class="btn btn-rounded btn-success ml-3">Download Examination Card</button>
                    </div>
                </div>


                <div class="form-group col-md-6">
                    <img src="../dist-assets/images/faces/1.jpg" alt="">
                </div>
                <div class="form-group col-md-6">
                    <h3>Batch Details: 1/2021<h3>
                            <h3>Tier: Tier-3<h3>
                </div>
                <div class="col-md-4">
                    <label for="inputEmail1" class="ul-form__label"><strong>First Name:</strong></label>
                    <div>Hadiza </div>
                </div>

                <div class="col-md-4">
                    <label for="inputEmail1" class="ul-form__label"><strong>Middle Name:</strong></label>

                    <div>Olubunmi</div>
                </div>

                <div class="col-md-4">
                    <label for="inputEmail1" class="ul-form__label"><strong>Surname:</strong></label>

                    <div>Ikechukwu </div>
                </div>



                <div class="col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Address:</strong></label>

                    <div>57 Campbell Street </div>

                </div>
                <div class="col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>

                    <div>Lagos </div>

                </div>
                <div class="col-md-4">

                    <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong> </label>

                    <div>Lagos Island</div>
                </div>
            </div>

            <div class="custom-separator"></div>
            <h4>Uploaded Documents</h4>


            <div class="custom-separator"></div>
            <div class="row">
                <div class="col-md-4">
                    <label for="inputEmail5" class="ul-form__label">Birth Certificate or Declaration of Age:</label>
                    <br /><a href="#" class="btn btn-info">DOWNLOAD DOCUMENT</a>
                </div>
                <div class="col-md-4">
                    <label for="inputEmail5" class="ul-form__label">Educational Credentials:</label>
                    <br /><a href="#" class="btn btn-info">DOWNLOAD DOCUMENT</a>
                </div>
                <div class="col-md-4">
                    <label for="inputEmail5" class="ul-form__label">Health Related Academic Training
                        Credentials:</label>
                    <br /><a href="#" class="btn btn-info">DOWNLOAD DOCUMENT</a>
                </div>

            </div>


            <!--</div>-->
            <div class="custom-separator"></div>
            <h4>Patent Medicine Vendor Shop</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Shop Name:</strong></label>
                    <div>ABC Medicine Shop</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Shop Phone:</strong></label>
                    <div>08029089895</div>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Shop Email:</strong></label>
                    <div>email@domain.com</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail3" class="ul-form__label"><strong>Shop Address:</strong></label>
                    <div> 42 Airport Road,
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail3" class="ul-form__label"><strong>Town/City:</strong></label>
                    <div>Shogunle</div>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                    <div>Lagos</div>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong></label>
                    <div>Ikeja</div>

                </div>


                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Are you registered?</strong> </label>
                    <div>YES</div>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>PPMVL Number :</strong></label>
                    <div>FG123535342523</div>
                </div>








            </div>
            <div class="custom-separator"></div>
            <h4>Training Centre</h4>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail3" class="ul-form__label"><strong>Preferred Training Centre</strong></label>
                    <div class="input-right-icon">Lagos Training Center 2</div>
                </div>
            </div>

            <!--<div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn  btn-primary m-1" id="save" name="save" >Approve MEPTP Application</button>
                                                   <button type="submit" class="btn  btn-danger m-1" id="query" name="query" >Query MEPTP Application</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

        </div>

        <!-- end::form -->

    </div>

</div>
@endsection