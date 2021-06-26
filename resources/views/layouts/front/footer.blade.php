{{--<footer class="footer-section footer">--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12 text-center">--}}

                {{--<ul class="footer-menu">--}}
                    {{--<li> <a href="{{ route('accounts', ['tab' => 'profile']) }}">Perfil</a>  </li>--}}
                    {{--<li> <a href="">Fale Conosco</a>  </li>--}}
                    {{--<li> <a href="">Termos de serviço</a>  </li>--}}
                {{--</ul>--}}

                {{--<ul class="footer-social text-success">--}}
                    {{--<li> <a href="https://www.facebook.com/OrganicosParaTodosAAT"> <i class="fa fa-facebook text-primary" aria-hidden="false"></i>  </a> </li>--}}
                    {{--<li> <a href=""> <i class="fa fa-twitter" aria-hidden="true"></i>   </a> </li>--}}
                    {{--<li> <a href="https://www.instagram.com/organicosparatodos/"> <i class="fa fa-instagram text-primary" aria-hidden="true"></i>  </a> </li>--}}
                    {{--<li> <a href=""> <i class="fa fa-pinterest-p" aria-hidden="true"></i>  </a> </li>--}}
                {{--</ul>--}}

                {{--<p>&copy; <a href="{{ config('app.url') }}">{{ config('app.name') }}</a> Todos os direitos Reservados</p>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</footer>--}}


<!-- Footer Section Begin -->
<footer class="footer spad" style="">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="{{route('home')}}">
                            <img src="img/logo_feira.png" alt="" width="25%">
                        </a>
                    </div>
                    <ul>
                        <li>Endereço: R. Fritz Weber, 75 - Fazendinha, Teresópolis - RJ</li>
                        <li>Whatsapp:&nbsp;&nbsp;<a href={{env('WHATSAPP_GROUP')}}>
                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                Participar</a></li>
                        <li>Email: {{env('CONTACT_SITE')}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Links Úteis</h6>
                    <ul>
                        <li><a href="http://organicosparatodos.com.br/">Sobre a AAT</a></li>
                        {{--<li><a href="#">About Our Shop</a></li>--}}
                        {{--<li><a href="#">Secure Shopping</a></li>--}}
                        {{--<li><a href="#">Delivery infomation</a></li>--}}
                        {{--<li><a href="#">Privacy Policy</a></li>--}}
                        {{--<li><a href="#">Our Sitemap</a></li>--}}
                    </ul>
                    <ul>
                        {{--<li><a href="#">Who We Are</a></li>--}}
                        {{--<li><a href="#">Our Services</a></li>--}}
                        {{--<li><a href="#">Projects</a></li>--}}
                        {{--<li><a href="#">Contact</a></li>--}}
                        {{--<li><a href="#">Innovation</a></li>--}}
                        {{--<li><a href="#">Testimonials</a></li>--}}
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Join Our Newsletter Now</h6>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form action="#">
                        <input type="text" placeholder="Enter your mail">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="{{env('LINK_FACEBOOK')}}"><i class="fa fa-facebook"></i></a>
                        <a href="{{env('LINK_INSTAGRAM')}}"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                    {{--<div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>--}}
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
{{--<script src="{{asset('js/jquery.nice-select.min.js')}}"></script>--}}
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/jquery.slicknav.js')}}"></script>
<script src="{{asset('js/mixitup.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
    });
    function sendAjax(formId) {
        // this is the id of the form
        //
        idf = "#" + formId;
        //
        $(idf).ready(function () {
        });
        //
        $(idf).submit(function (e) {
            //
            e.preventDefault(); // avoid to execute the actual submit of the form.
            //
            //
            var url = '{{route('front.add.cart')}}'
            //
            $.ajax({
                type: "POST",
                url: url,
                data: $(idf).serialize(),
                success: function (data) {
                    // console.log(data.message);
                    //  alert(data); // show response from the php script.
                    swal({
                        text: data.message,
                        icon: data.status
                    });


                    var cartNumber = parseInt($("#cartNumber").text()) +1;
                    console.log('Carrinho: ' +  cartNumber);
                    $("#cartNumber").text(cartNumber);

                },
                error: function(jqXhr, json, errorThrown, data){
                    var error = jqXhr.responseJSON.errors['product'];
                    console.log();
                  swal({
                      text:error[0],
                      icon: 'error'
                        });
                }
            });

        });
    }
    //
</script>

