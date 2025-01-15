@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Help')

<style>
.faq-item {
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.faq-question {
    font-weight: bold;
    color: #007bff;
    transition: color 0.2s ease-in-out;
}

.faq-question:hover {
    color: #0056b3;
    text-decoration: underline;
}

.faq-answer {
    margin-top: 10px;
    color: #555;
}

</style>


@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <h1 class="text-center mb-4">FAQ</h1>
                <div class="faq-section">
                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">How to get the eSIMs Cloud sharing link through API?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>You can retrieve the eSIMs Cloud sharing link by calling the appropriate endpoint in the API documentation.</p>
                        </div>
                    </div>
                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">Can I change the eSIM package name?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Yes, eSIM package names can be customized through the API settings panel.</p>
                        </div>
                    </div>
                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">What are the supported languages in sandbox and production?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Currently, the API supports multiple languages including English, Spanish, and French in both sandbox and production environments.</p>
                        </div>
                    </div>
                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">How can I set up prices in WooCommerce?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Prices in WooCommerce can be configured through the Partner API WooCommerce plugin.</p>
                        </div>
                    </div>
                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">What Service Network Provider (SPN) will show up when my user tries to install an eSIM purchased through the Partner API?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>The SPN shown will depend on the eSIM purchased and its associated carrier.</p>
                        </div>
                    </div>








                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">Are promotional prices on Airalo’s B2C products (airalo.com) applied to API Partners?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Promotional prices are applied only if the partner account has been configured for it.</p>
                        </div>
                    </div>

                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">Can I build a complete white label experience using the Airalo Partner API?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Yes, the Partner API supports building white-label solutions for your customers.</p>
                        </div>
                    </div>


                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">What does the QR code link return if an eSIM is installed and deleted?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>The QR code link will return the status of the eSIM, indicating whether it is installed, deleted, or inactive.</p>
                        </div>
                    </div>

                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">How can I access regional packages?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Regional packages can be accessed through the API by specifying the region in your request.</p>
                        </div>
                    </div>


                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">What are the different statuses of eSIM packages?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>The statuses include active, inactive, expired, and pending activation.</p>
                        </div>
                    </div>

                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">Where can I find information for the manual and QR code installation methods on iOS and Android devices?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>Detailed information is available in the API documentation under the installation section.</p>
                        </div>
                    </div>

                    <div class="faq-item mb-3">
                        <h6 class="faq-question" style="cursor: pointer;">Can I install and activate eSIMs purchased in the sandbox environment?</h6>
                        <div class="faq-answer" style="display: none;">
                            <p>eSIMs in the sandbox environment are for testing purposes only and cannot be activated for real use. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Toggle the visibility of the answer when the question is clicked
        $(".faq-question").click(function() {
            $(this).next(".faq-answer").slideToggle();
        });
    });
</script>
