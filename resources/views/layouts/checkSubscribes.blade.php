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
        @if ($watch = App\Watch::where('title', $rank['tag'])->first())
          @if (strpos($watch->videos()->first()->tags, '綜藝') !== false)
            <td>綜藝</td>
          @elseif (strpos($watch->videos()->first()->tags, '日劇') !== false)
            <td>日劇</td>
          @elseif (strpos($watch->videos()->first()->tags, '動漫') !== false)
            <td>動漫</td>
          @endif
        @else
          <td>TAG</td>
        @endif
	      <td>{{ $rank['tag'] }}</td>
	      <td style="text-align: center">{{ $rank['count'] }}</td>
	    </tr>
    @endforeach
  </tbody>
</table>