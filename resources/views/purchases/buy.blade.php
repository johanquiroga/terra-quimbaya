@extends('home')

@section('page', 'signup-page')

@section('styles')
    @parent
    <link href="{{asset('custom-assets/custom_material-kit.css')}}" rel="stylesheet"/>
@endsection

@section('main_content')
    <div class="header header-filter" style="background-image: url('{{asset("img/ImagenesTerra/DSCN7055.JPG")}}'); background-size: cover; background-position: top center;">
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-6 col-sm-offset-3">
                    <div class="card card-signup"><!--Header-->
                        <div class="header header-primary text-center">
                            <h4><i class="fa fa-user-circle"></i> Confirmar datos</h4>
                        </div>
                        <div class="content">
                            <form method="post" action="https://sandbox.gateway.payulatam.com/ppp-web-gateway/">
                                <input name="merchantId"    type="hidden"  value="{{ $merchanId or '508029' }}"   >
                                <input name="accountId"     type="hidden"  value="{{ $accountId or '512321' }}" >
                                <input name="description"   type="hidden"  value="{{ $description or 'Test PAYU' }}"  >
                                <input name="referenceCode" type="hidden"  value="{{ $referenceCode or 'TestPayU' }}" >
                                <input name="amount"        type="hidden"  value="{{ $amount }}"   >
                                <input name="tax"           type="hidden"  value="{{ $tax or '' }}"  >
                                <input name="taxReturnBase" type="hidden"  value="{{ $taxReturnBase or '0' }}" >
                                <input name="currency"      type="hidden"  value="{{ $currency }}" >
                                <input name="signature"     type="hidden"  value="{{ $signature }}"  >
                                <input name="test"          type="hidden"  value="1" >
                                <input name="buyerEmail"    type="hidden"  value="{{ $buyerEmail }}" >
                                <input name="buyerFullName" type="hidden"  value="{{ $buyerFullName }}">
                                <input name="shippingAddress" type="hidden" value="{{ $shippingAddress }}">
                                <input name="shippingCity" type="hidden" value="{{ $shippingCity }}">
                                <input name="shippingCountry" type="hidden" value="{{ $shippingCountry }}">
                                <input name="algorithmSignature" type="hidden" value="{{ $algorithmSignature }}">
                                <input name="responseUrl" type="hidden" value="{{ $responseUrl }}">
                                <input name="confirmationUrl"    type="hidden"  value="{{ $confirmationUrl }}" >
                                <input name="Submit"        type="submit"  value="Enviar" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection