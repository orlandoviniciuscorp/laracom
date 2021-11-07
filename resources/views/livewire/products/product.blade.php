<div>

    {{--    @if($product->quantity > 0)--}}
    @if($inStock)
        <form name="form" id="form" wire:submit.prevent="submit()"
              action="{{ route('cart.store') }}" class="form-inline" method="post" >

            {{ csrf_field() }}
            <div class="pro-qty">
                <input type="text"  name="quantity" wire:model="quantity" id="quantity">
            </div>
            <input wire:model="product_id" value=""type="hidden"  >

            <button type="submit"  id="add-to-cart-btn" name="add-to-cart-btn" type="submit" class="btn btn-success"
                    data-toggle="modal" data-target="#cart-modal">
                <i class="fa fa-cart-plus">
                    Comprar
                </i>
            </button>

        </form>
        @if ($errors->any())
            <h4>{{ $errors->first() }}</h4>
        @endif
    @else
        <span class="soldout">
             <h3 style="color: red">Esgotado</h3>
        </span>
    @endif

</div>