<style>
th {
    font-weight: bold;
    width: auto;
}
</style>

<table>
    <thead>
    <tr style="font-weight: bold">
        <th>Date</th>
        <th>Rooms</th>
        <th>Reservation time (hrs)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rooms as $room)
        <tr>
            <td>{{ $room->date }}</td>
            <td>{{ $room->room_name }}</td>
            <td>{{ $room->count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
