<footer class="footer-section footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">

                <ul class="footer-menu">
                    <li> <a href="{{ route('accounts', ['tab' => 'profile']) }}">Perfil</a>  </li>
                    <li> <a href="">Fale Conosco</a>  </li>
                    <li> <a href="">Termos de serviço</a>  </li>
                </ul>

                <ul class="footer-social text-success">
                    <li> <a href="https://www.facebook.com/demedeiros.organico.3"> <i class="fa fa-facebook text-primary" aria-hidden="false"></i>  </a> </li>
                    {{--<li> <a href=""> <i class="fa fa-twitter" aria-hidden="true"></i>   </a> </li>--}}
                    <li> <a href="https://www.instagram.com/sitio.demedeiros"> <i class="fa fa-instagram text-primary" aria-hidden="true"></i>  </a> </li>
                    {{--<li> <a href=""> <i class="fa fa-pinterest-p" aria-hidden="true"></i>  </a> </li>--}}
                </ul>

                <p>&copy; <a href="{{ config('app.url') }}">{{ config('app.name') }}</a> Todos os direitos Reservados</p>

            </div>
        </div>
    </div>
</footer>