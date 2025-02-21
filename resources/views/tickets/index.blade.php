@extends('main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Mis Tickets</h1>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Precio</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ number_format($ticket->price, 2) }} €</td>
                            <td>
                                @if ($ticket->isDeleted)
                                    <span class="badge bg-danger">Eliminado</span>
                                @else
                                    <span class="badge bg-success">Activo</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
