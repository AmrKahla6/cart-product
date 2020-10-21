<div class="col-lg-12 col-sm-12 col-12 main-section">
    <div class="dropdown">
        <button type="button" class="btn btn-info" data-toggle="dropdown">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
        </button>
        <div class="dropdown-menu">
            <div class="row total-header-section">
                <div class="col-lg-6 col-sm-6 col-6">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                </div>

                <?php $total = 0;
                      $texes = 0;
                ?>
                @foreach((array) session('cart') as $id => $details)
                    <?php $total += $details['price'] * $details['quantity'] ;
                          $texes = ($total * 14) / 100 ;
                    ?>
                @endforeach

                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                    <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                    <p>Texes: <span class="text-info">$ {{ number_format($texes, 2) }}</span></p>
                </div>
            </div>

            @if(session('cart'))
                @foreach((array) session('cart') as $id => $details)
                    <div class="row cart-detail">
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                            <p>{{ $details['name'] }}</p>
                            <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                    <a href="{{ url('cart') }}" class="btn btn-primary btn-block">View all</a>
                </div>
            </div>
        </div>
    </div>
</div>
