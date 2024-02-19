<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Helfer {{ date('Y') }}</title>
    <style>
        body {
            font-family: Cerebri Sans, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
        }
    </style>
</head>
<body>
<h1 style="font-weight: bold; font-size: 24px; max-width: 100%; margin-bottom: 25px;">Helfer {{ date('Y') }}</h1>
<div>
    @foreach($chips as $chip)
        @if($chip['selected'])
            <div style="display: inline-block; margin: 0 10px 10px 0">
                {{ $chip['label']  }}: <b>{{ $chip['options'][$chip['selected']] }}</b>
            </div>
        @endif
    @endforeach
</div>
<div style="margin-top: 25px">
    <a style="margin-right: 30px; font-weight: bold">XS: {{ $tshirtCount['XS'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">S: {{ $tshirtCount['S'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">M: {{ $tshirtCount['M'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">L: {{ $tshirtCount['L'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">XL: {{ $tshirtCount['XL'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">2XL: {{ $tshirtCount['2XL'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">3XL: {{ $tshirtCount['3XL'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">4XL: {{ $tshirtCount['4XL'] }}</a>
    <a style="margin-right: 30px; font-weight: bold">5XL: {{ $tshirtCount['5XL'] }}</a>
</div>
<table cellpadding="0" cellspacing="0" style="margin-top: 40px">
    <thead>
    <tr>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Name</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Ressort</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Freitag</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Samstag</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Sonntag</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">T-Shirt</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Essen</th>
        <th style="padding: 8px 15px 8px 0; text-align: left; white-space: nowrap">Allergien</th>
    </tr>
    </thead>
    <tbody>
    @foreach($persons as $person)
        <tr>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->name }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->ressortCategoryName }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->friday }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->saturday }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->sunday }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->t_shirt_size }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; white-space: nowrap; border-bottom: 1px solid #1a202c">
                {{ $person->food }}
            </td>
            <td style="text-align: left; padding: 8px 15px 8px 0; border-bottom: 1px solid #1a202c">
                {{ $person->allergies }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>

