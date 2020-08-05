<?php

namespace App\Http\Controllers\Auth\Admin;

use DB;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * NotificationController constructor.
     *
     * @param  Notification  $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.notification.index')->withNotifications($this->notification->paginate(config('access.default_size')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $notification = Notification::create($request->all());

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem while creating notification. Please try again.'));
        }

        DB::commit();

        return redirect()->route('admin.notification.index')->withFlashSuccess('Notification was created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        return view('admin.notification.edit')->withNotification($notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        DB::beginTransaction();

        try {

            $notification = $notification->update($request->all());

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem while updating notification. Please try again.'));
        }

        DB::commit();

        return redirect()->route('admin.notification.index')->withFlashSuccess('Notification was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        DB::beginTransaction();

        try {

            $notification->delete();

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem while deleting notification. Please try again.'));
        }

        DB::commit();

        return redirect()->route('admin.notification.index')->withFlashSuccess('Notification was deleted successfully');
    }
}
