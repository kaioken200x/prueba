<!DOCTYPE html>
<html>
<head>
    <title>Informe de Tareas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Informe de Tareas</h1>
    <table>
        <thead>
            <tr>
                <th>ID del Proyecto</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Minutos</th>
                <th>Nombre del Usuario</th>
                <th>Tareas Realizadas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->project_id }}</td>
                    <td>{{ $task->start_datetime }}</td>
                    <td>{{ $task->end_datetime }}</td>
                    <td>{{ $task->minutes }}</td>
                    <td>{{ $task->project->user ? $task->project->user->name : 'N/A' }}</td>
                    <td>{{ $task->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>