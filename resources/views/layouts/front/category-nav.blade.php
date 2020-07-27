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
                                                @foreach($categories as $category)
                                                        <li><a href="{{route('front.category.slug',$category->slug)}}">{{$category->name}}</a></li>
                                                @endforeach

                                        </ul>
                                </div>
                        </div>
                        <div class="col-lg-9">
                                <div class="hero__search">
                                        <div class="hero__search__form">
                                                <form action="{{route('search.product')}}">
                                                        <div class="hero__search__categories">
                                                                Todos os Produtores

                                                        </div>
                                                        <input type="text" name="q" placeholder="Do que você precisa?">
                                                        <button type="submit" class="site-btn">Buscar</button>
                                                </form>
                                        </div>
                                        <div class="hero__search__phone">
                                                <div class="hero__search__phone__icon">
                                                        <a href='https://chat.whatsapp.com/DPprk8jugf8DxqEs16Qfkv'>
                                                                <i class="fa fa-whatsapp"></i>
                                                        </a>

                                                </div>
                                                <div class="hero__search__phone__text">
                                                        <a href='https://chat.whatsapp.com/DPprk8jugf8DxqEs16Qfkv'>
                                                                <h5>Whatsapp</h5>
                                                        </a>
                                                        <span>Participe do Grupo</span>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="container">
                        <br />
                        @include('layouts.errors-and-messages')
                </div>
        </div>

</section>