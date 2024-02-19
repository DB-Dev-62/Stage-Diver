<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Schichtplan von {{ $person->name }}</title>
    <style>
        body {
            font-family: Cerebri Sans, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
        }
    </style>
</head>
<body>
<h1>{{ strtoupper($account->name) }} Schichtplan {{ date('Y') }}</h1>
<h2>von {{ $person->name }}</h2>
<h3 style="margin-top: 40px;">{{ $person->workload }} Stunden insgesamt</h3>
<hr>
<table style="font-size: 14px; margin-top: 20px;">
    @foreach($person->ressortWorkShifts as $ressortWorkShift)
        <tr>
            <td style="padding: 20px 10px 0 0; font-weight: bold">
                {{ $ressortWorkShift->day }}
            </td>
            <td style="padding: 20px 10px 0 0; min-width: 100px">
                {{ $ressortWorkShift->time_start }} - {{ $ressortWorkShift->time_end }} Uhr
            </td>
            <td style="padding: 20px 10px 0 0;">
                {{ $ressortWorkShift->ressort->name }}
            </td>
        </tr>
    @endforeach
    <!--

        //Helfer Optional
        <tr>
            <td style="padding: 0 10px 10px 0;"></td>
            <td style="padding: 0 10px 10px 10px;"></td>
            @ if($ressortWorkShift->supporter_min == $ressortWorkShift->supporter_max)
                <td style="padding: 0 10px 10px 10px; font-size: 14px">{{ $ressortWorkShift->supporter_min }} Helfer Schicht
                    <br>
                    <span style="font-weight: bold">Info</span>
                    <br>
                    <span>{{$ressortWorkShift->ressort->info}}</span>
                </td>
            @ else
                <td style="padding: 0 10px 10px 10px; font-size: 14px">{{ $ressortWorkShift->supporter_min }} Helfer
                    Schicht + {{ $ressortWorkShift->supporter_max - $ressortWorkShift->supporter_min }} Optional
                </td>
            @ endif
        </tr>
    -->
</table>
<br>
<hr>
<h3 style="padding: 15px 0px 0px 0px;">Infos</h3>
@foreach ($infos as $ressort => $info)
    <p style="padding: 0px 0px 10px 0px; font-size: 14px"><b>{{ $ressort }}:</b><br> {{ $info }}</p>
@endforeach
</body>
</html>

