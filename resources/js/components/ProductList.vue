<template>
<div class="row">
    <div class="col-lg-12 col-md-12 ">

        <div class="row">
            <div class="col-lg-6 col-md-5">
                <h2>Produtor: </h2>
            </div>
        </div>
        @endisset
        <div class="filter__item">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="filter__found">
                        <h6><span></span> Produtos Encontrados</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset("storage/$product->cover")}}">
                    <ul class="product__item__pic__hover">
                        <li><form name="" id=""
                                  class="form-inline" method="post"
                                  onsubmit="">

                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-inline"/>
                            <input type="hidden" name="product" value="">
                            <button id="add-to-cart-btn" name="add-to-cart-btn" type="submit" class="btn btn-success"
                                data-toggle="modal" data-target="#cart-modal">
                                <i class="fa fa-cart-plus">
                                    Comprar
                                </i>
                            </button>
                        </form>
                        </li>

                    </ul>
                </div>
                <div class="product__item__text">
                    <h6><a href="#">PRODUTO</a></h6>
                    <h5>R$ 100.00</h5>
                </div>
            </div>
        </div>

    </div>
    <div class="row justify-content-center">
    </div>
    <br />
</div>

</template>

<scrip>
    export default{}
</scrip>