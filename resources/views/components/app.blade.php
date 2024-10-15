<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/app.css">
</head>

<body class="bg-secondary">
    <h1 class="text-center bg-black text-white py-2">Simple TODO APP</h1>
    <h2 class="text-center text-white">TODO LIST</h2>

    <div class="container-lg bg-light p-5 mb-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger w-100">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="todo-form" action={{ route('todo.post') }} method="POST">
            @csrf

            <div class="input-group mb-5">
                <input type="text" name='task' class="form-control" placeholder="Masukkan todo anda"
                    value="{{ old('task') }}" aria-label="Masukkan todo anda" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="submit" id="button-addon2">Tambah</button>
            </div>
        </form>
    </div>

    <div class="container-lg bg-light p-5 ">
        <form action={{ route('todo') }} method="GET">
            <div class="input-group mb-3">


                <input type="text" name="search" value="" class="form-control " placeholder="Cari Todo"
                    aria-label="Cari Todo" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="submit" id="button-addon2">Cari</button>

            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Task</th>
                    <th>
                        Telah Selesai
                    </th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->task }}</td>
                        <td>
                            @if ($item->is_done == '1')
                                Selesai
                            @else
                                Belum
                            @endif
                        </td>
                        <td class="d-flex  gap-2 justify-content-center">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                class="btn btn-warning" data-task="{{ $item->task }}" data-id="{{ $item->id }}"
                                data-isDone="{{ $item->is_done }}" data-index="{{ $loop->index }}">Edit</button>



                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Hapus
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Anda yakin ingin menghapus data ini?
                                        </div>
                                        <form method="POST" action={{ route('todo.delete', ['id' => $item->id]) }}>

                                            @csrf
                                            @method('delete')
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}

        <!-- Modal -->
        <form id="edit-form" method="POST">
            @csrf
            @method('put')
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Task</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-column gap-4 input-group mb-2">
                                <input type="text" name="task" class="form-control w-100" id="taskInput"
                                    placeholder="Masukkan todo anda" aria-label="Masukkan todo anda"
                                    aria-describedby="button-addon2">

                                <div>
                                    <label>
                                        <input id='r-1' type="radio" value="1" name=is_done> Selesai
                                    </label>
                                    <label>
                                        <input id='r-2' type="radio" value="0" name=is_done> Belum
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            const staticBackdrop = document.getElementById('staticBackdrop');
            staticBackdrop.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-* attributes
                const id = button.getAttribute('data-id');
                const task = button.getAttribute('data-task');
                const is_done = button.getAttribute('data-isDone');
                const index = button.getAttribute('data-index');
                const editForm = document.getElementById('edit-form');

                // Update the modal's content
                staticBackdrop.querySelector('#taskInput').value = task;

                if (is_done == 1) {
                    staticBackdrop.querySelector('#r-1').checked = true;
                    staticBackdrop.addCh
                } else {
                    staticBackdrop.querySelector('#r-2').checked = true;
                }

                editForm.setAttribute('action', `/${id}`);
            });
        </script>

        <!-- Include Bootstrap JS and Popper.js for modal functionality -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>
</body>

</html>
