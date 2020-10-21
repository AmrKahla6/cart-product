@extends('layout')

@section('title', 'Cart')

@section('content')

    <span id="status"></span>

    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Total item</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>

        <?php $total = 0 ;
              $texes = 0;
        ?>

        @if(session('cart'))
            @foreach((array) session('cart') as $id => $details)

                <?php $total += $details['price'] * $details['quantity'];
                      $texes = ($total * 14) / 100 ;
                      $pTotal = $total + $texes;
                ?>

                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{ $details['price'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                    </td>
                    <td data-th="Subtotal" class="text-center">$<span class="product-subtotal">{{ $details['price'] * $details['quantity'] }}</span></td>
                    <td class="actions" data-th="">
                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                        <i class="fa fa-circle-o-notch fa-spin btn-loading" style="font-size:24px; display: none"></i>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
        <tfoot>
            <tr>
                <td><a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center"><strong>Subtotal $<span class="cart-total">{{ $total }}</span></strong></td>
            </tr>
        <tr class="visible-xs">
            <td class="text-center"><strong>Subtotal : $<span class="cart-total">{{ $total }}</span></strong></td>
        </tr>
        <tr class="visible-xs">
            <td class="text-center"><strong>Taxes : $<span class="cart-total">{{ number_format($texes, 2) }}</span></strong></td>
        </tr>
        <tr>
             <th class="hidden-xs">Discounts:</th>
         </tr>
              @php
              $dShoes = -2.499;
              $dJacket = -9.995;
              $totalDis = $dShoes + $dJacket;
              $ftotal = $pTotal + $totalDis;
             @endphp

              <tr>
              <td class="text-center"><strong>10% off shoes : $<span class="cart-total">{{ $dShoes }}</span></strong></td>
              </tr>
                <tr>
                <td class="text-center"><strong>50% off jacket : $<span class="cart-total">{{ $dJacket }}</span></strong></td>
             </tr>
             <tr class="visible-xs">
                <td class="text-center"><strong>Total : $<span class="cart-total"> {{ $ftotal, 2 }}</span></strong></td>
            </tr>

        </tfoot>
    </table>



@endsection

@section('scripts')


    <script type="text/javascript">

        $(".update-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            var parent_row = ele.parents("tr");

            var quantity = parent_row.find(".quantity").val();

            var product_subtotal = parent_row.find("span.product-subtotal");

            var cart_total = $(".cart-total");

            var loading = parent_row.find(".btn-loading");

            loading.show();

            $.ajax({
                url: '{{ url('update-cart') }}',
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: quantity},
                dataType: "json",
                success: function (response) {

                    loading.hide();

                    $("span#status").html('<div class="alert alert-success">'+response.msg+'</div>');

                    $("#header-bar").html(response.data);

                    product_subtotal.text(response.subTotal);

                    cart_total.text(response.total);
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            var parent_row = ele.parents("tr");

            var cart_total = $(".cart-total");

            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    dataType: "json",
                    success: function (response) {

                        parent_row.remove();

                        $("span#status").html('<div class="alert alert-success">'+response.msg+'</div>');

                        $("#header-bar").html(response.data);

                        cart_total.text(response.total);
                    }
                });
            }
        });

    </script>

@endsection
