<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo_feira.jpg" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="{{route('cart.index')}}"><i class="fa fa-shopping-cart"></i> <span>{{$cartCount}}</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>{{$totalCartItens}}</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__auth">
            @if(auth()->check())
                <a href="{{ route('accounts', ['tab' => 'profile']) }}">
                    <i class="fa fa-home"></i> {{auth()->user()->name}}</a></li>
            @else
                <a href="{{ route('login') }}"> <i class="fa fa-lock"></i> Login</a>
                <a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> Registrar</a>
            @endif
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="{{route('home')}}">Home</a></li>
            <li><a href="{{route('product.list')}}">Produtos</a></li>
            <li><a href="{{route('cart.index')}}">Carrinho de Compas</a></li>
            <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>
            <li><a href="#">Usuário</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">Meu Perfil</a></li>
                    <li><a href="{{route('cart.index')}}">Pedidos</a></li>
                </ul>
            </li>

        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="{{env('LINK_FACEBOOK')}}"><i class="fa fa-facebook"></i></a>
        <a href="{{env('LINK_INSTAGRAM')}}"><i class="fa fa-instagram"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> {{env('CONTACT_SITE')}}</li>
            <li>Produtos Orgânicos diretamente do Produtor</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> {{env('CONTACT_SITE')}}</li>
                            <li>Produtos Orgânicos diretamente do Produtor</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="{{env('LINK_FACEBOOK')}}"><i class="fa fa-facebook"></i></a>
                            <a href="{{env('LINK_INSTAGRAM')}}"><i class="fa fa-instagram"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            @if(auth()->check())
                                <a href="{{ route('accounts', ['tab' => 'profile']) }}">
                                    <i class="fa fa-home"></i> {{auth()->user()->name}}</a></li>

                                <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Sair</a>
                            @else
                                <a href="{{ route('login') }}"> <i class="fa fa-lock"></i> Login</a>
                                <a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> Registrar</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{route('home')}}"><img src="{{asset('img/logo_feira.jpg')}}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">

                    <ul>
                        <li class="active"><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('product.list')}}">Produtos</a></li>
                        <li><a href="{{route('cart.index')}}">Carrinho de Compas</a></li>
                        <li><a href="#">Usuário</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="{{route('accounts')}}">Meu Perfil</a></li>
                                <li><a href="{{route('orders')}}">Pedidos</a></li>
                            </ul>
                        </li>
                        <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>

                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="{{route('cart.index')}}"><i class="fa fa-shopping-cart"></i> <span>{{$cartCount}}</span></a></li>
                    </ul>
                    <div class="header__cart__price">item: <span>{{$totalCartItens}}</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>

<!-- Header Section End -->

