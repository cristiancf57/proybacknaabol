
<!-- Top Selling -->
<div class="col-12">
  <div class="card top-selling overflow-auto">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filtrar</h6>
        </li>
        <li><a class="dropdown-item" href="#">Today</a></li>
        <li><a class="dropdown-item" href="#">This Month</a></li>
        <li><a class="dropdown-item" href="#">This Year</a></li>
      </ul>
    </div>
    <div class="card-body pb-0">
      <h5 class="card-title">Usuarios <span>| Hoy</span></h5>
      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre Apellido</th>
            <th scope="col">email</th>
            <th scope="col">telefono</th>
            <th scope="col">username</th>
            <th scope="col">cargo</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($usuarios as $user)
          <tr>
            <th scope="row"><a href="#">{{$user->id}}</a></th>
            <td><a href="#" class="text-primary fw-bold">Ut {{$user->nombre}} {{$user->apellido}}</a></td>
            <td>{{$user->email}}</td>
            <td>{{$user->telefono}}</td>
            <td>{{$user->username}}</td>

            {{-- <td>
                @if($reporte->estado === 'nuevo')
                    <span class="badge bg-danger">{{ $reporte->estado }}</span>
                @elseif($reporte->estado === 'culminado')
                    <span class="badge bg-success">{{ $reporte->estado }}</span>
                @else
                    <span class="badge bg-secondary">{{ $reporte->estado }}</span>
                @endif
            </td> --}}
            
            <td>{{$user->cargo->descripcion}}</td>
          </tr>
          @endforeach
          {{-- <tr>
            <td><span class="badge bg-warning">Pending</span></
            <td><span class="badge bg-success">Approved</span></
            <td><span class="badge bg-danger">Rejected</span></
          </tr> --}}
          
        </tbody>
      </table>
    </div>
  </div>
</div><!-- End Top Selling -->