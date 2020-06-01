<!-- Page Preloder -->
{{--<div id="preloder">--}}
    {{--<div class="loader"></div>--}}
{{--</div>--}}

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo_feira.jpg" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__auth">
            @if(auth()->check())
                <a href="{{ route('accounts', ['tab' => 'profile']) }}"><i class="fa fa-home"></i> Minha Conta</a></li>
            @else
                <a href="{{ route('login') }}"> <i class="fa fa-lock"></i> Login</a>
                <a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> Registrar</a>
            @endif
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="./index.html">Home</a></li>
            <li><a href="./shop-grid.html">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">Shop Details</a></li>
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                    <li><a href="./checkout.html">Check Out</a></li>
                    <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>
                </ul>
            </li>
            <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>
            <li><a href="./contact.html">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-instagramp"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> contato@organicosaat.com.br</li>
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
                            <li><i class="fa fa-envelope"></i> contato@organicosaat.com.br</li>
                            <li>Produtos Orgânicos diretamente do Produtor</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            {{--<a href="#"><i class="fa fa-twitter"></i></a>--}}
                            {{--<a href="#"><i class="fa fa-linkedin"></i></a>--}}
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            @if(auth()->check())
                                <a href="{{ route('accounts', ['tab' => 'profile']) }}"><i class="fa fa-home"></i> Minha Conta</a></li>
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
                        <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shop-details.html">Shop Details</a></li>
                                <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                <li><a href="./checkout.html">Check Out</a></li>
                                <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>
                            </ul>
                        </li>
                        <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                        <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                    </ul>
                    <div class="header__cart__price">item: <span>$150.00</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>

<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Produtores</span>
                    </div>
                    <ul>
                        @foreach($cats as $cat)
                            <li><a href="{{route('front.category.slug',$cat->slug)}}">{{$cat->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                Todas as Categorias
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="Do que você precisa?">
                            <button type="submit" class="site-btn">Buscar</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            {{--<i class="fa fa-phone"></i>--}}
                        </div>
                        <div class="hero__search__phone__text">
                            {{--<h5>+65 11.188.888</h5>--}}
                            {{--<span>support 24/7 time</span>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Header Section End -->

