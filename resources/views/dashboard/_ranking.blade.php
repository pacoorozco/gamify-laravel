<table id="ranking" class="table table-hover">
    <thead>
    <tr>
        <th class="col-md-1">#</th>
        <th class="col-md-6">Player</th>
        <th class="col-md-3">Level</th>
        <th class="col-md-2">Points</th>
    </tr>
    </thead>
    @foreach($usersInRanking as $index => $userInRank)
        <tr>
            <td>{{ $index+1 }}</td>
            <td><a href="{{ route('profiles.show', $userInRank['username']) }}">{{ $userInRank['name'] }}</a></td>
            <td>{{ $userInRank['level'] }}</td>
            <td>{{ $userInRank['experience'] }}</td>
        </tr>
    @endforeach
    <tfoot>
    <tr>
        <th class="col-md-1">#</th>
        <th class="col-md-6">Player</th>
        <th class="col-md-3">Level</th>
        <th class="col-md-2">Points</th>
    </tr>
    </tfoot>
</table>
