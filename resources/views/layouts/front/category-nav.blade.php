<section class="hero hero-normal">
        <div class="container">
                <form action="{{route('search.product')}}" name="form_search" id="form_search">
                <div class="row">

                        <div class="col-lg-3">
                                <div class="hero__categories">
                                        <div class="hero__categories__all">
                                                <i class="fa fa-bars"></i>
                                                <span>Categorias</span>
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

{{--                                                        <div class="hero__search__categories">--}}
{{--                                                                Buscar--}}

{{--                                                        </div>--}}
                                                        <input type="text" name="q" placeholder="Do que você precisa?"
                                                        @if(request()->has("q"))
                                                                value="{!! request()->get("q") !!}"
                                                        @endif
                                                        >
                                                        <button type="submit" class="site-btn">Buscar</button>
                                                        <br />


                                        </div>

                                        <div class="hero__search__phone">
                                                <div class="hero__search__phone__icon">
                                                        <a href={{env('WHATSAPP_GROUP')}}>
                                                                <i class="fa fa-whatsapp"></i>
                                                        </a>

                                                </div>
                                                <div class="hero__search__phone__text">
                                                        <a href={{env('WHATSAPP_GROUP')}}>
                                                                <h5>Whatsapp</h5>
                                                        </a>
                                                        <span>Participe do Grupo</span>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                        <br />
{{--                <div class="row">--}}
{{--                        <div class="col-lg-2">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2">--}}
{{--                                <label for="exclude_sold_out" >Esconder esgotados: &nbsp;</label>--}}
{{--                                <input type="checkbox" id="exclude_sold_out"--}}
{{--                                       name="exclude_sold_out"--}}
{{--                                       onclick="submitForm()"--}}
{{--                                       @if(app('request')->input('exclude_sold_out') != null)--}}
{{--                                        checked--}}
{{--                                       @endif--}}
{{--                                       value="1"--}}
{{--                                />--}}


{{--                        </div>--}}
{{--                        <div class="col-lg-1">--}}
{{--                                <label for="order_id" >Ordenação: </label>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2">--}}
{{--                                <select id="order_id" name="order" onchange="submitForm()">--}}
{{--                                        <option value="0">Padrão</option>--}}
{{--                                        <option value="1"--}}
{{--                                        @if(app('request')->input('order') != null &&--}}
{{--                                            app('request')->input('order') == 1)--}}
{{--                                                selected--}}
{{--                                        @endif--}}
{{--                                                >Alfabética</option>--}}
{{--                                </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2">--}}
{{--                                <label for="page_itens" >Itens por Página: </label>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-2">--}}
{{--                                <select id="page_itens" name="page_itens" onchange="submitForm()">--}}
{{--                                        <option value="0"--}}
{{--                                        @if(app('request')->input('page_itens') != null &&--}}
{{--                                            app('request')->input('page_itens') == 0)--}}
{{--                                                selected--}}
{{--                                        @endif>Padrão</option>--}}
{{--                                        <option value="10"--}}
{{--                                                @if(app('request')->input('page_itens') != null &&--}}
{{--                                                    app('request')->input('page_itens') == 10)--}}
{{--                                                selected--}}
{{--                                        @endif>10</option>--}}
{{--                                        <option value="15"--}}
{{--                                                @if(app('request')->input('page_itens') != null &&--}}
{{--                                                    app('request')->input('page_itens') == 15)--}}
{{--                                                selected--}}
{{--                                        @endif>15</option>--}}
{{--                                        <option value="50"--}}
{{--                                                @if(app('request')->input('page_itens') != null &&--}}
{{--                                                    app('request')->input('page_itens') == 50)--}}
{{--                                                selected--}}
{{--                                        @endif>50</option>--}}
{{--                                </select>--}}
{{--                        </div>--}}

{{--                </div>--}}
                </form>
                <div class="container">
                        <br />
                        @include('layouts.errors-and-messages')
                </div>
        </div>
        @isset($products)
        <div class="filter__item">
                <div class="row">
                        <div class="col-lg-4 col-md-5">
                        </div>
                        <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
{{--                                        <h6><span>{{$products->total()}}</span> Produtos Encontrados</h6>--}}
                                </div>
                        </div>
                </div>
        </div>
        @endisset

</section>

@section('post-script')
        <script>
                function submitForm(){

                        document.getElementById("form_search").submit();
                }

        </script>
@endsection