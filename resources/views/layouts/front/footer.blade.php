{{--<footer class="footer-section footer">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12 text-center">--}}
{{----}}
{{--                <ul class="footer-menu">--}}
{{--                    <li> <a href="{{ route('accounts', ['tab' => 'profile']) }}">Perfil</a>  </li>--}}
{{--                    <li> <a href="">Fale Conosco</a>  </li>--}}
{{--                    <li> <a href="">Termos de serviço</a>  </li>--}}
{{--                </ul>--}}
{{----}}
{{--                <ul class="footer-social text-success">--}}
{{--                    <li> <a href="https://www.facebook.com/OrganicosParaTodosAAT"> <i class="fa fa-facebook text-primary" aria-hidden="false"></i>  </a> </li>--}}
                    <li> <a href=""> <i class="fa fa-twitter" aria-hidden="true"></i>   </a> </li>
{{--                    <li> <a href="https://www.instagram.com/organicosparatodos/"> <i class="fa fa-instagram text-primary" aria-hidden="true"></i>  </a> </li>--}}
                    <li> <a href=""> <i class="fa fa-pinterest-p" aria-hidden="true"></i>  </a> </li>
{{--                </ul>--}}
{{----}}
{{--                <p>&copy; <a href="{{ config('app.url') }}">{{ config('app.name') }}</a> Todos os direitos Reservados</p>--}}
{{----}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}




<!-- Start Footer  -->
<footer>
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-top-box">
                        <h3>Funcionamento</h3>
                        <ul class="list-time">
                            <li>Pedidos de Sexta-feira Até Terça-feira</li> <li>Entregas: Quinta-Feira</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-top-box">
                        <h3>Newsletter</h3>
                        <form class="newsletter-box">
                            <div class="form-group">
                                <input class="" type="email" name="Email" placeholder="Email Address*" />
                                <i class="fa fa-envelope"></i>
                            </div>
                            <button class="btn hvr-hover" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-top-box">
                        <h3>Redes Sociais</h3>
                        <p> Nos Siga nas Redes Sociais</p>
                        <ul>
                            <li><a href="{{env('FACEBOOK_LINK')}}"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
{{--                            <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>--}}
                            <li><a href="{{env('INSTAGRAM_LINK')}}"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="{{env('WHATSAPP_PHONE')}}"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-widget">
                        <h4>Sobre o Na Despensa</h4>
                        <p>Uma plataforma de vendas de alimentos online de produtores iniciantes, do interior, com selo orgânico e ou agroecológicos.</p>
                        <p>Oferecer produtos diversificados, muitos deles sem presença no mercado tradicional, a preço justo com entrega a domicílio. Valorizando o pequeno e médio produtor.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-link">
                        <h4>Information</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Customer Service</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Delivery Information</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-link-contact">
                        <h4>Contact Us</h4>
                        <ul>
{{--                            <li>--}}
{{--                                <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street Wichita,<br> KS 67213 </p>--}}
{{--                            </li>--}}
                            <li>
                                <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:{{env('PHONE_NUMBER')}}">{{env('PHONE_NUMBER')}}</a></p>
                            </li>
                            <li>
                                <p><i class="fas fa-envelope"></i>Email: <a href="mailto:nadespensaoficial@gmail.com">nadespensaoficial@gmail.com</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer  -->

<!-- Start copyright  -->
<div class="footer-copyright">
    <p class="footer-company">All Rights Reserved. &copy; {{ date("Y")}}
        <a href="{{route('home')}}">NaDespensa</a> Design By :
        <a href="https://html.design/">html design</a></p>
</div>
<!-- End copyright  -->

<a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

<!-- ALL JS FILES -->
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- ALL PLUGINS -->
<script src="{{asset('js/jquery.superslides.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.js')}}"></script>
<script src="{{asset('js/inewsticker.js')}}"></script>
<script src="{{asset('js/bootsnav.js')}}"></script>
<script src="{{asset('js/images-loded.min.js')}}"></script>
<script src="{{asset('js/isotope.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/baguetteBox.min.js')}}"></script>
<script src="{{asset('js/form-validator.min.js')}}"></script>
<script src="{{asset('js/contact-form-script.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>