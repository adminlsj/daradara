<table class="table">
  <thead>
    <tr>
      <th scope="col">Rank</th>
      <th scope="col">Genre</th>
      <th scope="col">Tag</th>
      <th scope="col">Subscribes</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($rankings as $rank)
	    <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#e5e5e5' : 'white' }}">
	      <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ App\Watch::where('title', $rank['tag'])->first() ? App\Watch::where('title', $rank['tag'])->first()->genre() : 'TAG' }}</td>
	      <td>{{ $rank['tag'] }}</td>
	      <td style="text-align: center">{{ $rank['count'] }}</td>
	    </tr>
    @endforeach
  </tbody>
</table>