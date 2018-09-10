<div class="card-order">
	<button onclick="selectJob()">
        <div> {{ $job->title }} </div>
        <div> {{ $job->company->name }} </div>
        <div> {{ $job->location }} </div>
        <div> {{ $job->created_at->diffForHumans() }} </div>
        <hr>
    </button>
</div>

<script>
	function myFunction() {
	    document.getElementById("demo").innerHTML = "Hello World";
	}
</script>