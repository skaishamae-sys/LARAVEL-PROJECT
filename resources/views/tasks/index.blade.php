<!DOCTYPE html>
<html>
<head>
    <title>Personal Task Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            text-align: center;
        }

        .add-button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #e5e7eb;
        }

        .edit {
            background: #f59e0b;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete {
            background: #dc2626;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .success {
            background: #d1fae5;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Personal Task Manager</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

   <a href="/tasks/create" class="add-button">
    + Add Task
</a>
    </a>

    <table>
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($tasks as $task)

                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->due_date }}</td>

                    <td>

   <a href="/tasks/{{ $task->id }}/edit" class="edit">
    Edit
</a>
                        <form action="/tasks/{{ $task->id }}"
      method="POST"
      style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="delete"
                                    onclick="return confirm('Delete this task?')">
                                Delete
                            </button>

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">
                        No tasks yet.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

</body>
</html>