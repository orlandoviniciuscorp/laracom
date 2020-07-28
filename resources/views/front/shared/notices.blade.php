<link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
<section>
    <div class="container">
        <p>
        <h2>
            <a href="{{ route('accounts', ['tab' => 'profile']) }}"
               style="font-size:150%">
                Clique aqui para continuar no Organicos aat</a>
            <br />
            <br />
            Ou Aguarde 10 segundos e será redirecionado.
        </h2>
        </p>
        <br />
        <div class="row justify-content-center" style="width: 100%;">
            <a href="https://youtu.be/jYCMam79BXw" target="_blank">
                <img src="{{asset('img/aviso.jpeg')}}" style="width: 80%"/>
            </a>
        </div>
        <br />
    </div>

</section>

<script type="text/javascript">
    (function(){
        setTimeout(function(){
            window.location="{{ route('accounts', ['tab' => 'profile']) }}";
        },10000); /* 1000 = 1 second*/
    })();
</script>

