<table class="table">
  <thead>
    <tr>
      <th scope="col">Rank</th>
      <th scope="col">Genre</th>
      <th scope="col">Title</th>
      <th scope="col">Subscribes</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($sortedWatches as $watch)
	    <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#e5e5e5' : 'white' }}">
	      <th scope="row">{{ $loop->iteration }}</th>
	      <td>{{ $watch->genre() }}</td>
	      <td>{{ $watch->title }}</td>
	      <td>{{ $watch->subscribes()->count() }}</td>
	    </tr>
    @endforeach
  </tbody>
</table>