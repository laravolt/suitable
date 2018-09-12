<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<h2 style="text-align: center;">{{ $title }}</h2>
<table style="border: 1px solid black">
    <thead>
    <tr>
        @foreach($headers as $header)
            @if($header->isSortable())
                {!! $header->getHtml() !!}
            @else
                <th {!! $header->renderAttributes() !!}>{!! $header->getHtml() !!}</th>
            @endif
        @endforeach
    </tr>
    </thead>
    <tbody class="collection">
    @forelse($collection as $data)
        @php($outerLoop = $loop)
        @if($row)
            @include($row)
        @else
            <tr>
                @foreach($fields as $field)
                    <td {!! $builder->renderCellAttributes($field, $data) !!}>{!! $builder->renderCell($field, $data, $collection, $outerLoop) !!}</td>
                @endforeach
            </tr>
        @endif
    @empty
        @include('suitable::empty')
    @endforelse
    </tbody>
</table>
</body>
</html>