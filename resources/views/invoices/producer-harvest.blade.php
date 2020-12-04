{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <title>{{env('APP_NAME')}} - Colheita</title>--}}
{{--    --}}{{--<link rel="stylesheet" href="{{asset('css/style.min.css')}}">--}}
{{--    <style>--}}
{{--        table {--}}

{{--        }--}}
{{--        table, th, td {--}}
{{--            border: 1px solid black;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<section class="container">--}}
{{--<!-- Default box -->--}}
{{--    <h2>{{env('APP_NAME')}} - Colheita</h2>--}}
{{--    @if($harvest)--}}
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


                @foreach ($colheita as $c)

                    @foreach($c['produtor'] as $key=>$value)
                    <tr>
                        <td>
                            {{$key}}
                        </td>
                        <td>
                            {{$c['produto']}}
                        </td>
                        <td>
                            {{$value}}
                        </td>
                    </tr>
                    @endforeach
                @endforeach
        </table>
{{--        <!-- /.box-body -->--}}

{{--        <!-- /.box -->--}}

{{--    @endif--}}

{{--</section>--}}

{{--</body>--}}
{{--</html>--}}