<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Colheita</title>
    {{--<link rel="stylesheet" href="{{asset('css/style.min.css')}}">--}}
    <style>
        table {

        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<section class="container">
<!-- Default box -->
    <h2>Colheita</h2>
    @if($harvest)
        <table border="0" style="border: 1px solid black">
            <tr>
                <th>
                    Sítio
                </th>
                <th>
                    Produto
                </th>
                <th>
                    Quantidade
                </th>
            </tr>
                @foreach ($harvest as $hav)

                    <tr>
                        <td>
                            {{$hav->produtor}}
                        </td>
                        <td>
                            {{$hav->produto}}
                        </td>
                        <td>
                            {{$hav->quantidade}}
                        </td>
                    </tr>
                @endforeach
        </table>
        <!-- /.box-body -->

        <!-- /.box -->

    @endif

</section>

</body>
</html>