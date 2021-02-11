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

        <table border="0" style="border: 1px solid black; text-align: center;">
            <tr>
                <td colspan="3" style="border: 1px solid black; text-align: center;">
                    <strong>Planilha de Colheita da Feira - #{{$fair->id}}</strong>
                </td>
            </tr>

            <tr>
                <td colspan="3" style="border: 1px solid black; text-align: center;">
                    <strong>{{$fair->end_at}}</strong>
                </td>
            </tr>

            <tr>
                <th style="border: 1px solid black; text-align: center;">
                    <strong>Sítio</strong>
                </th>
                <th  style="border: 1px solid black; text-align: center;">
                    <strong>Produto</strong>
                </th>
                <th style="border: 1px solid black; text-align: center;">
                    <strong>Qtd</strong>
                </th>
            </tr>


                @foreach ($colheita as $c)

                    @foreach($c['produtor'] as $key=>$value)
                    <tr>
                        <td style="border: 1px solid black; text-align: center; width: 20px;">
                            {{$key}}
                        </td>
                        <td style="border: 1px solid black; text-align: center; width: 80px;">
                            {{$c['produto']}}
                        </td>
                        <td style="border: 1px solid black; text-align: center; width: 5px; ">
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