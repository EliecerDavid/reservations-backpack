<table>
    <thead>
    <tr>
        <th>Client</th>
        <th>Room</th>
        <th>Status</th>
        <th>Reservation start</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->booker->name }}</td>
            <td>{{ $reservation->room->name }}</td>
            <td>{{ $reservation->status }}</td>
            <td>{{ $reservation->reservation_start }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
