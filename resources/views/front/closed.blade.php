<div class="container  text-center">
    <br />
    <div class="row justify-content-center">
        <h2>
            Estamos preparando os seus pedidos.
        </h2>
    </div>

    <div class="row justify-content-center">
        <h3>
            Participe do grupo do Whatsapp para ficar informado de novidades
            <br ><br >
            <button
                    @if(current_shop()==1)
                        onclick="location.href='{{env('WHATSAPP_GROUP')}}'"
                    @else
                        onclick="location.href='{{env('GROUP_RIO_LINK')}}'"
                    @endif
                    type="button" class="btn-success">


                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                Participar</button>
        </h3>
    </div>

    <div class="row justify-content-center" style="margin-top: 10px;">
        <h3>
            @if(current_shop() == 1)
                Aberto para pedidos de 3a feira, a partir das 17hs, até 5a feira às 18hs. Entrega aos sábados
                <br /> <br />
                Os produtos podem ser visto quando a cesta estiver aberta.
            @else
                Próxima Abertura da Cesta será dia: {{$config->getNextFairDateFormatado()}}
            @endif
        </h3>
    </div>
    <div class="row justify-content-center">

        <div class="image-clean">
            <img src="{{asset('img/logo-feira-teresopolis-grande.jpg')}}" class="img-thumbnail"/>
        </div>
    </div>
    <div class="row justify-content-center">
        <br />
        <h2>

            <br />
        Agradecemos pela visita.
        </h2>

    </div>

</div>
<br/>
<br/>
