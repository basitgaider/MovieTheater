@extends("layouts.layout")
@section("title")
Movie-Checkout
@endsection

@section("main")

<!-- ==========Banner-Section========== -->
<section class="details-banner hero-area bg_img seat-plan-banner" data-background="./assets/images/banner/banner04.jpg">
    <div class="container">
        <div class="details-banner-wrapper">
            <div class="details-banner-content style-two">
                <h3 class="title">{{$cinema->Theatre_name}}</h3>
                <div class="tags">
                    <a href="#0">{{$cinema->Theatre_area}}</a>
                    <a href="#0">{{$cinema->Theatre_city}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Page-Title========== -->
<section class="page-title bg-one">
    <div class="container">
        <div class="page-title-area">
            <div class="item md-order-1">
                <a href="/movieticketplan.html" class="custom-button back-button">
                    <i class="flaticon-double-right-arrows-angles"></i>back
                </a>
            </div>
            <div class="item date-item">
                <span class="date">{{$show->date}}</span>
                <select class="select-bar">
                    <option value="sc1">{{$show->timing}}</option>
                </select>
            </div>
            <div class="item">
                <h5 class="title">05:00</h5>
                <p>Mins Left</p>
            </div>
        </div>
    </div>
</section>
<!-- ==========Page-Title========== -->

<!-- ==========Movie-Section========== -->
<div class="movie-facility padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-widget checkout-contact">
                    <h5 class="title">Share your Contact Details </h5>
                    <form class="checkout-contact-form">
                        <div class="form-group">
                            <input type="text" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Enter your Mail">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Enter your Phone Number ">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Continue" class="custom-button">
                        </div>
                    </form>
                </div>
                <div class="checkout-widget checkout-contact">
                    <h5 class="title">Promo Code </h5>
                    <form class="checkout-contact-form">
                        <div class="form-group">
                            <input type="text" placeholder="Please enter promo code">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Verify" class="custom-button">
                        </div>
                    </form>
                </div>
                <div class="checkout-widget checkout-card mb-0">
                    <h5 class="title">Payment Option </h5>
                    <ul class="payment-option">
                        <li class="active">
                            <a href="#0">
                                <img src="{{asset('./assets/images/payment/card.png')}}" alt="payment">
                                <span>Credit Card</span>
                            </a>
                        </li>
                        <li>
                            <a href="#0">
                                <img src="{{asset('./assets/images/payment/card.png')}}" alt="payment">
                                <span>Debit Card</span>
                            </a>
                        </li>
                        <li>
                            <a href="#0">
                                <img src="{{asset('assets/images/payment/paypal.png')}}" alt="payment">
                                <span>paypal</span>
                            </a>
                        </li>
                    </ul>
                    <h6 class="subtitle">Enter Your Card Details </h6>
                    <form class="payment-card-form" method="post" action="/payment_insertion">
                        @csrf
                        <div class="form-group w-100">
                            <label for="card1">Card Details</label>
                            <input type="text" id="card1" name="card_details">
                            <div class="right-icon">
                                <i class="flaticon-lock"></i>
                            </div>
                        </div>
                        <div class="form-group w-100">
                            <label for="card2"> Name on the Card</label>
                            <input type="text" id="card2" name="card_name">
                        </div>
                        <div class="form-group">
                            <label for="card3">Expiration</label>
                            <input type="text" id="card3" name="expiration" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label for="card4">CVV</label>
                            <input type="text" id="card4" name="cvv" placeholder="CVV">
                        </div>
                        <div class="form-group check-group">
                            <input id="card5" type="checkbox" checked>
                            <label for="card5">
                                <span class="title">QuickPay</span>
                                <span class="info">Save this card information to my Boleto account and make faster payments.</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="custom-button" value="make payment">
                        </div>
                    </form>
                    <p class="notice">
                        By Clicking "Make Payment" you agree to the <a href="#0">terms and conditions</a>
                    </p>
                    @if(session('payment_status'))
                    <div class="alert alert-success">
                        {{ session('payment_status') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="booking-summery bg-one">
                    <h4 class="title">booking summery</h4>
                    <ul>
                        <li>
                            <h6 class="subtitle">{{$cinema->Theatre_name}}</h6>
                            <span class="info">English-2d</span>
                        </li>
                        <li>
                            <h6 class="subtitle"><span>{{$cinema->Theatre_area}}</span><span>02</span></h6>
                            <div class="info"><span>10 SEP TUE, 11:00 PM</span> <span>Tickets</span></div>
                        </li>
                        <h4 class="subtitle mb-0">Seat Details</h4>

                        @foreach($tickets as $ticket)
                        <li>
                            <span>Seat Number: {{ $ticket->seat_number }}</span><br>
                            <span>Status: {{ $ticket->seat_class }}</span><br>
                            <span>Ticket Price: {{ $ticket->price }}</span>
                        </li>
                        @endforeach

                    </ul>
                </div>
                <div class="proceed-area text-center">
                    <h6 class="subtitle">
                        <span>Amount Payable</span>
                        <span>{{ collect($tickets)->sum('price') }}</span>
                    </h6>
                    <a href="/booking_confirmation" class="custom-button back-button">proceed</a><br>
                    @if(session('booking_confirm'))
                    <div class="alert alert-success">
                        {{ session('booking_confirm') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ==========Movie-Section========== -->
@endsection