@foreach ($results as $electionId => $election)
<h2>{{ $election['title'] }}</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Votes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($election['results'] as $result)
        <tr>
            <td>{{ $result['name'] }}</td>
            <td>{{ $result['votes'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach