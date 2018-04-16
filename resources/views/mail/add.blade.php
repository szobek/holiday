<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Valaki felvitt egy szabadságot! <br>
    <table>
        <thead>
            <tr>
                <th>Név</th>
                <th>Cég</th>
                <th>Kezdete</th>
                <th>Vége</th>
                <th>Típus</th>
                <th>Megjegyzés</th>
                <th>Megtekintés</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$data->name}}</td>
                <td>{{$data->company}}</td>
                <td>{{$data->start->date}}</td>
                <td>{{$data->end->date}}</td>
                <td><{{$data->type}}/td>
                <td>{{$data->description}}</td>
                <td>{{$data->description}}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>