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

        div.holiday {
            position: absolute;
            background: #fff;
            height: 15px;
            left: -147px;
            width: 146px;
            z-index: 2000003;
            color: black;
            top: 15px;
        }

        .no-print {
            width: 100%;
            margin: 20px 15px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }

        .tokesuly-num {
            position: absolute;
            top: 10px;
            left: 425px;
            width: 250px;
        }



    </style>
</head>
<body>

<div class="container">

    <div class="no-print" onclick="window.print()">
        <button class="btn btn-primary">Nyomtatás</button>
    </div>
    <div class="no-print">

        <label for="year">Év</label>
        <select name="year" id="year">
            @foreach($years as $y)
                <option value="{{ $y }}" @if((int)Request::segment(2) === $y) selected @endif>{{ $y }}</option>
            @endforeach
        </select>

        <label for="month">Hónap</label>
        <select name="month" id="month">
            @foreach($months as $m)
                <option value="{{ $m }}"  @if((int)Request::segment(3) === $m) selected @endif>{{ $m }}</option>
            @endforeach
        </select>
        <script>

            window.goToPdf = function (user, company) {
                let y = document.querySelector("#year").value, m = document.querySelector("#month").value;
                let url = `/pdf/${y}/${m}/${user}/${company}`;
                window.location = url;
            };
        </script>
        <button onclick="window.goToPdf({{$user->id}},{{$company->id}})">mutasd</button>
        <script>

        </script>
    </div>

    <div class="employer">
        <p>{{ $company->short_name }}</p>
        <p>
            {{ $company->address }} <br>
            {{ $company->tax }}
        </p>

        @if($company->id === 4)
            <section class="tokesuly-num">
                GINOP-2.1.7-15-2016-00105
            </section>
        @endif

        @if($company->id === 7)
            <section class="tokesuly-num">
                GINOP-2.1.7-15-2016-00187
            </section>
        @endif

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
            @foreach($pdfData as $key => $item)
                {{--{{ dd($loop)  }}--}}
                @if($item->num < 16)
                    <tr>
                        <td class="align daynum" rowspan="2">{{$item->num}}</td>
                        <td class="check">Érkezett</td>
                        <td class="fromto"></td>
                        <td class="sign"></td>
                        <td class="align hournum" rowspan="2">

                            {{--szabadság--}}
                            @if($item->sick)
                                <div class="holiday">Betegszabadság</div>
                            @elseif($item->holiday)
                                <div class="holiday">Szabadság</div>
                            {{--hétvége--}}
                            @elseif(!$item->workDay)
                                <div class="strikeout"></div>
                            {{--betegszabi--}}
                            @else

                            @endif
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

            @foreach($pdfData as $key => $item)
                @if($item->num > 15)
                    <tr>
                        <td class="align daynum" rowspan="2">{{$item->num}}</td>
                        <td class="check">Érkezett</td>
                        <td class="fromto"></td>
                        <td class="sign"></td>
                        <td class="align hournum" rowspan="2">

                            {{--szabadság--}}
                            @if($item->sick)
                                <div class="holiday">Betegszabadság</div>
                            @elseif($item->holiday)
                                <div class="holiday">Szabadság</div>
                                {{--hétvége--}}
                            @elseif(!$item->workDay)
                                <div class="strikeout"></div>
                                {{--betegszabi--}}
                            @else

                            @endif
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