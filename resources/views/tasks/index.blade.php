```php
<!DOCTYPE html>
<html>
<head>
    <title>Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .title-area h1 {
            margin: 0;
            font-size: 32px;
            color: white;
        }

        .title-area p {
            margin-top: 8px;
            color: #94a3b8;
        }

        .add-button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .add-button:hover {
            background: #1d4ed8;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .card {
            background: #1e293b;
            padding: 22px;
            border-radius: 12px;
            border: 1px solid #334155;
        }

        .card-title {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .card-number {
            color: white;
            font-size: 30px;
            font-weight: bold;
        }

        .task-container {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 14px;
            padding: 25px;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .task-header h2 {
            margin: 0;
            color: white;
        }

        .success {
            background: #14532d;
            color: #bbf7d0;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            color: #94a3b8;
            font-size: 13px;
            padding: 12px;
            border-bottom: 1px solid #334155;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #334155;
            color: #cbd5e1;
        }

        td:first-child {
            color: white;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #78350f;
            color: #fde68a;
        }

        .completed {
            background: #14532d;
            color: #bbf7d0;
        }

        .edit {
            background: #f59e0b;
            color: white;
            padding: 7px 11px;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 5px;
            font-size: 13px;
        }

        .delete {
            background: #dc2626;
            color: white;
            padding: 7px 11px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        .edit:hover {
            background: #d97706;
        }

        .delete:hover {
            background: #b91c1c;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #94a3b8;
        }

        @media (max-width: 700px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .task-container {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <div class="title-area">
            <h1>🌊 Personal Task Manager</h1>
            <p>Stay organized. One task at a time.</p>
        </div>

        <a href="/tasks/create" class="add-button">
            + Add Task
        </a>

    </div>


    @php
        $total = $tasks->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $completed = $tasks->where('status', 'Completed')->count();
    @endphp


    <div class="cards">

        <div class="card">
            <div class="card-title">TOTAL TASKS</div>
            <div class="card-number">{{ $total }}</div>
        </div>

        <div class="card">
            <div class="card-title">PENDING</div>
            <div class="card-number">{{ $pending }}</div>
        </div>

        <div class="card">
            <div class="card-title">COMPLETED</div>
            <div class="card-number">{{ $completed }}</div>
        </div>

    </div>


    <div class="task-container">

        <div class="task-header">
            <h2>My Tasks</h2>
        </div>


        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif


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

                        <td>
                            {{ $task->task_name }}
                        </td>

                        <td>
                            {{ $task->description }}
                        </td>

                        <td>

                            @if($task->status == 'Completed')

                                <span class="status completed">
                                    Completed
                                </span>

                            @else

                                <span class="status pending">
                                    Pending
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $task->due_date }}
                        </td>

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
                        <td colspan="5" class="empty">
                            🌊 No tasks yet. Add your first task!
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
```
