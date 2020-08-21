<!-- Start Main Top -->
<div class="main-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="custom-select-box">
                    <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
                        <option>R$ BRL</option>
                    </select>
                </div>
                <div class="right-phone-box">
                    <p><i class="fab fa-whatsapp">&nbsp;</i><a href="#">Whatsapp</a></p>
                </div>
                <div class="our-link">
                    <ul>
                        @if(auth()->check())
                            <li><a href="{{ route('accounts', ['tab' => 'profile']) }}"><i class="fa fa-user s_color"></i>Minha Conta</a></li>
                            <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i></i> Sair</a></li>
                        @else
                            <li><a href="{{route('login')}}"><i class="fas fa-lock"></i> Login</a></li>
                            <li><a href="{{route('register')}}"><i class="fas fa-sign-in-alt"></i> Registrar</a></li>
                        @endif

                        <li><a href="#"><i class="fas fa-headset"></i> Fale Conosco</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="login-box">
{{--                    <select id="basic" class="selectpicker show-tick form-control"  data-placeholder="Sign In">--}}
{{--                        <option>Registre-se Aqui</option>--}}
{{--                        <option>Login</option>--}}
{{--                    </select>--}}
                </div>
                <div class="text-slid-box">
                    <div id="offer-box" class="carouselTicker">
                        <ul class="offer-box">
                            <li>
                                <i class="fab fa-opencart"></i> Compras de 5a até domingo. Entrega às 3a feira
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Top -->

<!-- Start Main Top -->
<header class="main-header">
    <!-- Start Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-default bootsnav" style="background-color: black;">
        <div class="container">
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" class="logo" alt=""></a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="nav-item" id="teste"><a class="nav-link"  href="{{route('home')}}">Home</a></li>
                    <li class="nav-item" id="teste"><a class="nav-link" href="{{route('about')}}">Muito Prazer...</a></li>
                    <li class="nav-item" id="teste">
                        <a href="{{route('product.list')}}" class="nav-link">Produtos</a>
                    </li>
{{--                    <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li>--}}
                    <li class="nav-item" id="teste"><a class="nav-link" href="contact-us.html">Contatos</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                    <li>
                        <a href="{{route('cart.index')}}">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="badge">{{$cartCount}}</span>
                            <p>Carrinho</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->
        </div>
        <!-- Start Side Menu -->
{{--        <div class="side">--}}
{{--            <a href="#" class="close-side"><i class="fa fa-times"></i></a>--}}
{{--            <li class="cart-box">--}}
{{--                <ul class="cart-list">--}}
{{--                    <li>--}}
{{--                        <a href="#" class="photo"><img src="images/img-pro-01.jpg" class="cart-thumb" alt="" /></a>--}}
{{--                        <h6><a href="#">Delica omtantur </a></h6>--}}
{{--                        <p>1x - <span class="price">$80.00</span></p>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="#" class="photo"><img src="images/img-pro-02.jpg" class="cart-thumb" alt="" /></a>--}}
{{--                        <h6><a href="#">Omnes ocurreret</a></h6>--}}
{{--                        <p>1x - <span class="price">$60.00</span></p>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="#" class="photo"><img src="images/img-pro-03.jpg" class="cart-thumb" alt="" /></a>--}}
{{--                        <h6><a href="#">Agam facilisis</a></h6>--}}
{{--                        <p>1x - <span class="price">$40.00</span></p>--}}
{{--                    </li>--}}
{{--                    <li class="total">--}}
{{--                        <a href="{{route('cart.index')}}" class="btn btn-default hvr-hover btn-cart">Ver Carrinho</a>--}}
{{--                        <span class="float-right"><strong>Total</strong>: $180.00</span>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </div>--}}
{{--        <!-- End Side Menu -->--}}
    </nav>
    <!-- End Navigation -->
</header>
<!-- End Main Top -->
@include('layouts.errors-and-messages')
<!-- Start Top Search -->
<form action="{{route('search.product')}}">
<div class="top-search">
    <div class="container">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" name="q" placeholder="Do que você Precisa?">
            <button type="submit" class="btn btn-light" value="Pesquisar">Pesquisar</button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
        </div>
    </div>
</div>
</form>
<!-- End Top Search -->