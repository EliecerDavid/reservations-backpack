<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReservationsExport;
use App\Http\Requests\CreateReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ReservationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReservationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Reservation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/reservation');
        CRUD::setEntityNameStrings('reservation', 'reservations');

        CRUD::denyAccess(['delete']);

        if (backpack_user()->isAdmin()) {
            CRUD::denyAccess(['create']);
            CRUD::allowAccess(['export']);
        }

        if (backpack_user()->isClient()) {
            CRUD::denyAccess(['update']);

            $userId = backpack_auth()->id();
            CRUD::addBaseClause('byBooker', $userId);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('room')->type('text')
            ->value(fn ($reservation) => $reservation->room->name)
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('room', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            });

        if (backpack_user()->isAdmin()) {
            CRUD::column('booked_by')->type('text')
                ->value(fn ($reservation) => $reservation->booker->name)
                ->searchLogic(function ($query, $column, $searchTerm) {
                    $query->orWhereHas('booker', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    });
                });
        }

        CRUD::column('status')->type('text');
        CRUD::column('reservation_start')->type('datetime');
        CRUD::column('reservation_end')->type('datetime');

        CRUD::button('export')->stack('top')->view('crud::buttons.export');
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('room')->type('text')->value(fn ($reservation) => $reservation->room->name);
        CRUD::column('booked_by')->type('text')->value(fn ($reservation) => $reservation->booker->name);
        CRUD::column('status')->type('text');
        CRUD::column('reservation_start')->type('datetime');
        CRUD::column('reservation_end')->type('datetime');
        CRUD::column('reviewed_by')->type('text')->value(fn ($reservation) => $reservation->reviewer?->name);

        CRUD::column('created_at')->type('datetime');
        CRUD::column('updated_at')->type('datetime');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateReservationRequest::class);

        CRUD::field('room_id')->type('select')->entity('room');
        CRUD::field('reservation_start')->type('datetime');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateReservationRequest::class);

        CRUD::field('room')->type('select')->entity('room')->attributes(['disabled' => 'disabled']);
        CRUD::field('booked_by')->type('select')->entity('booker')->attributes(['disabled' => 'disabled']);
        CRUD::field('status')->type('select_from_array')->options(['pending' => 'pending', 'accepted' => 'accepted', 'rejected' => 'rejected']);
        CRUD::field('reservation_start')->type('datetime')->attributes(['disabled' => 'disabled']);
        CRUD::field('reservation_end')->type('datetime')->attributes(['disabled' => 'disabled']);
    }

    public function export()
    {
        CRUD::hasAccessOrFail('export');
        return (new ReservationsExport())->download('reservations.xlsx');
    }
}
