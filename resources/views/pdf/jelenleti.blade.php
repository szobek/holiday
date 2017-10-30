<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Jelenléti ív</title>
    <style>



        table.sheet {
            vertical-align: middle;
            text-align: center;
            /*display: inline-block;*/
            width: 330px;
            /*border-spacing: 10px;*/
            border-collapse: collapse;
            font-size: 12px;
            position: relative;

        }

        table tbody {
            position: relative;
        }

        thead {
            text-align: left;
        }

        thead td {
            height: 35px;
        }


        td {
            border: thin solid black;
            padding-left: 5px;
            padding-right: 5px;

        }

        td.align {

        }

        td.daynum {
            width: 20px;
        }

        td.fromto {
            font-size: 12px;
            min-width: 50px;
        }

        td.check {
            font-size: 12px;
            width: 65px;
        }

        td.sign {
            width: 70px !important;
        }

        td.hournum {
            font-size: 16px;
        }

        .half {
            width: 330px;
            float: left;
            display: inline-block;
            margin: 0 10px;
        }
        .clear {
            clear: both;
        }

        tbody td {
            height: 21px;
        }

        td.divider {
            height: 20px;
            border: none;
        }

        .employer {
            margin: 0 10px 20px 10px;
            width: 328px;
            height: 100px;
            border: thin solid black;
            position: relative;
            padding: 10px;
        }

        tr, td {
            position: relative;
        }

        div.strikeout {
            transform: rotate(8deg);
            width: 331px;
            border-bottom: 2px solid black;
            height: 1px;
            position: absolute;
            left: -257px;
            top: 21px;
        }



    </style>
</head>
<body>

<div class="container">

    <div class="employer">
        <p>{{ $company->short_name }}</p>
        <p>
            {{ $company->address }} <br>
            {{ $company->tax }}
        </p>

    </div>

    <div class="half">
        <table class="sheet">
            <thead>
            <tr>
                <td colspan="5">
                    Dolgozó neve: {{ $user->name }}
                </td>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="5" class="divider"></td></tr>
            <tr>
                <td class="align" colspan="3">Nap</td>
                <td class="align sign">Aláírás</td>
                <td class="align">Ledolg. óra</td>
            </tr>
            @foreach($items as $key => $item)
                {{--{{ dd($loop)  }}--}}
                @if($item['num'] < 16)
                    <tr>
                        <td class="align daynum" rowspan="2">{{$item['num']}}</td>
                        <td class="check">Érkezett</td>
                        <td class="fromto"></td>
                        <td class="sign"></td>
                        <td class="align hournum" rowspan="2">
                            @if(!$item['disabled'])  @else <div class="strikeout"></div> @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="check">Távozott</td>
                        <td class="fromto"></td>
                        <td class="sign"></td>
                    </tr>
                @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="half">
        <table class="sheet">
            <thead>
            <tr>
                <td colspan="5">
                    {{$year}}. év @lang('Carbon.month.' . $month) hónap
                </td>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="5" class="divider"></td></tr>
            <tr>
                <td class="align" colspan="3">Nap</td>
                <td class="align sign">Aláírás</td>
                <td class="align">Ledolg. óra</td>
            </tr>

            @foreach($items as $key => $item)
                {{--{{ dd($loop)  }}--}}
                @if($item['num'] > 15)
                    <tr>
                        <td class="align daynum" rowspan="2">{{$item['num']}}</td>
                        <td class="check">Érkezett</td>
                        <td class="fromto"></td>
                        <td class="sign"></td>
                        <td class="align hournum" rowspan="2">
                            @if(!$item['disabled'])  @else <div class="strikeout"></div> @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="check">Távozott</td>
                        <td class="fromto"></td>
                        <td class="sign"></td>
                    </tr>
                @endif
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="clear"></div>

</div>
















</body>
</html>