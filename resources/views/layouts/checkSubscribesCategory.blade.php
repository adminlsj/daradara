<table class="table">
  <thead>
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Name</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($subscribes as $subscribe)
	    <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#e5e5e5' : 'white' }}">
	      <td>{{ $subscribe->user()->email }}</td>
	      <td>{{ $subscribe->user()->name }}</td>
	    </tr>
    @endforeach
  </tbody>
</table>