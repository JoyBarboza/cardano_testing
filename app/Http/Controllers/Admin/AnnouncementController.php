<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AnnouncementController extends Controller
{
    public function index(){
        $announcements = Announcement::latest()->paginate(20);

        return view('announcement.index', compact('announcements'));
    }

    public function create(){
        return view('announcement.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title'      => 'required|max:255',
            'description'=> 'required',
            'status' => 'required|numeric',
        ]);

        try {

            Announcement::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
            ]);

            flash()->success(trans('auth/controller_msg.announcement_added_successfully'));

        } catch (\Exception $exception) {
            Log::error(trans('auth/controller_msg.announcement_Error_store').$exception->getMessage());

            flash()->error(trans('auth/controller_msg.announcement_Error_store'));
        }

        return redirect()->route('admin.announcement.index');
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('announcement.edit', compact('announcement'));

    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->title = $request->input('title');
        $announcement->description = $request->input('description');
        $announcement->status = $request->input('status');
        

        try {
            $announcement->save();

            flash()->success(trans('auth/controller_msg.Announcement_has_been_updated_successfully'));
        } catch (QueryException $exception) {

            Log::error(trans('auth/controller_msg.Announcement_update_query_exception').$exception->getMessage());
            flash()->error(trans('auth/controller_msg.Error_Announcement_updated_successfully'));

        } catch (\Exception $exception) {

            Log::error(trans('auth/controller_msg.Error_Announcement_update').' '.$exception->getMessage());
            flash()->error(trans('auth/controller_msg.Announcement_has_been_updated_successfully'));
        }

        return redirect()->route('admin.announcement.index');
    }

    public function changeStatus($id)
    {
        $announcement = Announcement::find($id);

        try {
            if($announcement->status) {
                $announcement->status = 0;
            } else {
                $announcement->status = 1;
            }

            $announcement->save();

            flash()->success(trans('auth/controller_msg.Announcement_status_modified'))->important();
        } catch (\Exception $exception) {
            Log::error(trans('auth/controller_msg.Announcement_status_has_been_changed'));

            flash()->error(trans('auth/controller_msg.Announcement_status_modification_failed'))->important();
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        try {
                if(Announcement::destroy($id)) {
                    return json_encode([
                        'status' => true,
                        'message' => trans('auth/controller_msg.Announcement_deleted_successfully')
                    ]);
                }

                return json_encode([
                    'status' => false,
                    'message' => trans('auth/controller_msg.Announcement_not_found_with_this_code')
                ]);

        } catch (\Exception $exception) {
            Log::error('Error! Deleting Pre Sale '. $exception->getMessage());

            return json_encode([
                'status' => false,
                'message' => trans('auth/controller_msg.failed_delete_Announcement')
            ]);
        }
    }
}
