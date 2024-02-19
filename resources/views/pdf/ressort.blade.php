<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ressourcenplan {{ $ressort->name }}</title>
    <style>
        body {
            font-family: Cerebri Sans, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
        }
    </style>
</head>
<body>
<h1>{{ strtoupper($account->name) }} Ressourcenplan {{ date('Y') }}</h1>
<h2>{{ $ressort->name }}</h2>
<hr>
<div style="font-size: 14px; margin-top: 20px;">
    @foreach($ressortWorkShifts as $ressortWorkShift)
        <div style="margin-bottom: 15px;">
            <span style="font-weight: bold">
                {{ $ressortWorkShift->day }}
            </span>
            <span>
                {{ $ressortWorkShift->time_start }} - {{ $ressortWorkShift->time_end }} Uhr
            </span>
        </div>
        <div style="margin-bottom: 35px;">
            <div>
                @foreach($ressortWorkShift->persons as $person)
                    @if($person->is_optional)
                        <span
                            style="background-color: #ddf6e4; font-size: 14px; display: inline-block; border: 1px solid #4a5568; padding: 10px; margin-right: 5px; margin-bottom: 5px">
                        {{ $person->name }}
                    </span>
                    @else
                        <span
                            style="font-size: 14px; display: inline-block; border: 1px solid #4a5568; padding: 10px; margin-right: 5px; margin-bottom: 5px">
                        {{ $person->name }}
                    </span>
                    @endif
                @endforeach
                @for ($i = 1; $i <= ($ressortWorkShift->supporter_min - sizeof(array_filter($ressortWorkShift->persons->toArray(), function ($v) { return $v['is_optional'] == "0"; }))); $i++)
                    <span
                        style="font-size: 14px; display: inline-block; border: 1px solid #4a5568; padding: 10px; margin-right: 5px; margin-bottom: 5px; height: 17px; width: 17px;">

                    </span>
                @endfor
                @for ($i = 1; $i <= ($ressortWorkShift->supporter_max - $ressortWorkShift->supporter_min - sizeof(array_filter($ressortWorkShift->persons->toArray(), function ($v) { return $v['is_optional'] == "1"; }))); $i++)
                    <span
                        style="background-color: #ddf6e4; font-size: 14px; display: inline-block; border: 1px solid #4a5568; padding: 10px; margin-right: 5px; margin-bottom: 5px; height: 17px; width: 17px;">

                    </span>
                @endfor
            </div>
        </div>
    @endforeach
</div>
<div>
    <hr>
    <br>
    <span style="font-weight: bold; font-size: 15px;padding: 15px 0 0 0;">Info</span>
    <br>
    <span style="font-size: 14px">{{$ressort->info}}</span>
</div>

</body>
</html>
