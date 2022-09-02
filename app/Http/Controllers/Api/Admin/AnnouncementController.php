<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\Announcement;

use App\Http\Resources\AnnouncementResource;
use App\Http\Controllers\Api\AnnouncementController as BaseAnnouncementController;

class AnnouncementController extends BaseAnnouncementController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $announcement = new Announcement();

        $announcement->fill($request->prepareData());

        $now = Carbon::now();
        $startDate = Carbon::parse($request->startDate);

        if ($now->lte($startDate))  $announcement->active = true;

        if (!$announcement->save()) {
            return response()->json([
                'message' => 'Something went wrong! Please try again later.',
                'status' => 'error'
            ]);
        }

        return new AnnouncementResource($announcement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->fill($request->prepareData());

        $now = Carbon::now();
        $startDate = Carbon::parse($request->startDate);

        if ($now->lte($startDate)) $announcement->active = true;;

        if (!$announcement->update()) {
            return Response::json([
                'message' => 'Something went wrong! Please try again later.',
                'status' => 'error'
            ]);
        }

        return new AnnouncementResource($announcement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        if (!$announcement->delete()) {
            return Response::json([
                'message' => 'Something went wrong! Please try again later.',
                'status' => 'error'
            ]);
        }

        return Response::json([
            'message' => 'Announcement deleted successfully!'
        ]);
    }
}
